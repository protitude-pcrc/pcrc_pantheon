<?php

$settings['update_free_access'] = false;
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = 'sites/default/files/private';

$additionalSettingsFiles = [
  ( DRUPAL_ROOT . "/../vendor/acquia/blt/settings/blt.settings.php" ),
  ( __DIR__ . "/settings.pantheon.php" ),
  ( __DIR__ . "/settings/local.settings.php" ), // for lando blt tests
  ( __DIR__ . "/local.settings.php" ) // more local settings
];

foreach ($additionalSettingsFiles as $settingsFile) {
  if (file_exists($settingsFile)) {
    require $settingsFile;
  }
}

$hash = getenv('DRUPAL_HASH_SALT');

$settings['hash_salt'] = $hash;

$settings['container_yamls'][] = __DIR__ . '/services.yml';

$settings['config_sync_directory'] = 'sites/default/config/default';

$settings['config_exclude_modules'] = [
  'smtp',
];
