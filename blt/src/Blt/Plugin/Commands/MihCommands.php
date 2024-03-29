<?php

namespace Example\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
use Drupal\Component\Utility\Crypt;
use Drupal\Component\Utility\Xss;

/**
 * Defines commands in the "mih" namespace.
 */
class MihCommands extends BltTasks {

  /**
   * Reload site with prod db.
   *
   * @command mih:landosetup
   * @description pull in production database.
   */
  public function landosetup(array $args) {
    if ($args) {
      $token = $args[0];
      $uid = $args[1] ?? 1;
    }
    else {
      $token = $this->ask("What is your GitHub token: ");
      $uid = $this->ask("What is your drupal user id: ");
    }
    // Not to self: Can't place composer install in here because
    // it needs to run before you can run this command.
    $this->_exec("mkdir -p web/sites/default/settings");
    $this->_exec("mkdir -p backups");
    $this->_exec("cp blt/lando.local.settings.php web/sites/default/settings/local.settings.php");
    $this->_exec("cp blt/behat.local.yml tests/behat/local.yml");
    $this->_exec("composer install --ignore-platform-reqs -n");
    $hash = Crypt::randomBytesBase64(55);
    $this->_exec("echo 'PANTHEON_ENVIRONMENT=local
DRUPAL_HASH_SALT=$hash
PCRC_UID=$uid
GITHUB_TOKEN=$token'>.env");
    $this->say("❗️ Environment vars setup, now starting  lando. ❗️");
    $this->_exec("lando start");
    $this->_exec("lando blt blt:telemetry:disable --no-interaction");
    $this->_exec("lando blt gh:pulldb");
    $this->_exec("lando blt gh:pullfiles");
    $this->_exec("mkdir -p web/sites/default/files/private");
    $this->_exec("lando blt mih:did");
    $this->_exec("lando drush deploy");
  }

  /**
   * Start lando.
   *
   * @command mih:start
   * @description Start lando and set GITHUB_TOKEN.
   */
  public function start() {
    $this->_exec("lando start");
    $this->_exec("blt mih:loadtoken");
  }

  /**
   * Load Token.
   *
   * @command mih:loadtoken
   * @description load GITHUB_TOKEN to composer.
   */
  public function loadToken() {
    if (getenv('GITHUB_TOKEN')) {
      $this->say("❗️ Setting GITHUB_TOKEN token. ❗️");
      $this->_exec("composer config -g github-oauth.github.com $(printenv GITHUB_TOKEN)");
      $this->_exec($this->lando() . " composer config -g github-oauth.github.com $(printenv GITHUB_TOKEN)");
    }
    else {
      $this->say("❗️ GITHUB_TOKEN not set. ❗️");
    }
  }

  /**
   * Run cypress tests.
   *
   * @command mih:cypress
   * @description Run Cypress.
   */
  public function cypress() {
    $this->_exec('cd tests/cypress && ' . $this->lando() . 'cypress run --config baseUrl=https://pcrc.lndo.site');
  }

  /**
   * Run behat.
   *
   * @command mih:behat
   * @description Run behat.
   */
  public function behat(array $args) {
    $arrrrgs = implode(',@', $args);
    $lando = $this->lando() == 'lando ' ? "lando ssh -c \"(" : "(";
    $lando_end = $this->lando() == 'lando ' ? "\"" : "";
    $shell_cmd = $lando . '\'google-chrome\' --headless --no-sandbox --disable-dev-shm-usage --disable-web-security --remote-debugging-port=9222 --window-size=1440,1080 &) | behat --format pretty /app/tests/behat --colors --no-interaction --stop-on-failure --config /app/tests/behat/local.yml --profile local -v 2>&1' . $lando_end;

    // Open a pipe to the command and capture its output.
    $descriptorspec = [
    // Stdin.
      0 => ["pipe", "r"],
    // Stdout.
      1 => ["pipe", "w"],
    // Stderr.
      2 => ["pipe", "w"],
    ];
    $process = proc_open($shell_cmd, $descriptorspec, $pipes);

    // Read the output from the command in real-time.
    while ($line = fgets($pipes[1])) {
      echo $line;
      $pattern = "/Failed scenarios/i";
      if (preg_match($pattern, $line)) {
        // Close the pipes and the process.
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        throw new \Exception('Failed behat tests.');
      }
    }

    // Close the pipes and the process.
    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $return_value = proc_close($process);
    if ($return_value !== 0) {
      throw new \Exception('Failed to execute the shell command.');
    }
  }

  /**
   * Get behat definition list.
   *
   * @command mih:behat:dl
   * @description Run behat.
   */
  public function behat_dl() {
    $lando = $this->lando() == 'lando ' ? "lando ssh -c \"(" : "(";
    $lando_end = $this->lando() == 'lando ' ? "\"" : "";
    $this->_exec($lando . '\'google-chrome\' --headless --no-sandbox --disable-dev-shm-usage --disable-web-security --remote-debugging-port=9222 &) | behat -dl  /app/tests/behat --config /app/tests/behat/local.yml --profile local' . $lando_end);
  }

  /**
   * Command prefix.
   */
  private function lando() {
    $lando = "lando ";
    if (getcwd() == '/app') {
      $lando = "";
    }
    return $lando;
  }

  /**
   * Login with user id.
   *
   * @command mih:uli
   * @description Login locally with personal user id set in github.
   */
  public function uli() {
    if ($this->lando() == 'lando ') {
      $this->_exec("export $(lando ssh -s appserver -c env | grep AMP_UID)");
    }
    $uid = Xss::filter(shell_exec("printenv PCRC_UID"));
    $this->_exec($this->lando() . "drush uli --uid=$uid");
  }

  /**
   * Reload site with prod db.
   *
   * @command mih:did
   * @description pull in production database.
   */
  public function did() {
    if ($this->lando() == 'lando ') {
      $this->_exec("lando db-import backups/site.sql.gz");
    }
    else {
      $this->_exec("drush sql-drop -y &&
        cp backups/site.sql.gz lando-import.sql.gz &&
        gunzip lando-import.sql.gz
        drush sqlc < lando-import.sql &&
        rm -fR lando-import.sql
      ");
    }
    $this->_exec($this->lando() . "drush deploy -y");
    $this->_exec($this->lando() . "drush cim -y");
    $this->_exec($this->lando() . "drush cr");
    $this->_exec($this->lando() . "blt mih:uli");
  }

  /**
   * Update ran in github actions.
   *
   * @command mih:ciupdate
   * @description Updates through CI.
   */
  public function ciupdate(array $args) {
    $module = $args[0];
    $version = $args[1];

    $this->_exec("touch log.txt");
    if ($module == 'drupal/core') {
      $this->_exec("composer update drupal/core-composer-scaffold drupal/core-recommended drupal/core-project-message drupal/core-dev -W --ignore-platform-req=ext-gd >log.txt 2>&1");
      $this->composer_updates('/Upgrading (drupal)\/core \((.* \=\> .*)\)$/mU');
    }
    elseif (!empty($module)) {
      if (!empty($version)) {
        $this->_exec("composer require $module $version --no-scripts --ignore-platform-req=ext-gd >log.txt 2>&1");
      }
      else {
        $this->_exec("composer update $module --no-scripts --ignore-platform-req=ext-gd >log.txt 2>&1");
      }
      $this->_exec("cat log.txt");
      $this->composer_updates('/Upgrading .*\/(.*)\((.* \=\> .*)\)$/m');
    }
  }

  /**
   *
   */
  private function composer_updates($regex) {
    $log = file_get_contents("log.txt");
    $log = preg_match_all($regex, $log, $update_matches);
    $this->say("-=-=-=-=-Log Message=-=-===-\n$log");
    $update_list = '';
    foreach ($update_matches[1] as $key => $update_match) {
      $seperator = $key > 0 ? ' — ' : '';
      $version = $update_matches[2][$key];
      $update_list .= "$seperator$update_match: $version";
    }
    // $this->_exec("lando drush updatedb -y");
    // $this->_exec("lando drush cr");
    if ($log > 0) {
      $this->say("\n The following updated:
$update_list");
      $this->_exec("git add composer.*");
      $this->_exec("git commit -m\"$update_list\"");
      $this->_exec("rm log.txt");
    }
  }

  /**
   * Run security updates.
   *
   * @command mih:su
   * @description Grab security updates and send to GitHub composer action.
   */
  public function su() {
    $security_updates = shell_exec("composer audit --format=json --no-dev");
    $security_updates = json_decode($security_updates, TRUE);
    $security_updates = $security_updates['advisories'];
    if (empty($security_updates)) {
      $this->say("No security updates found.");
      return;
    }
    foreach ($security_updates as $value) {
      $name = $value[0]['packageName'];
      $this->say("Sending update to GitHub composer action for $name");
      $this->_exec("gh workflow run updates.yml --ref main --repo github.com/protitude-pcrc/pcrc_pantheon -f drupal_update=$name");
    }
  }

}
