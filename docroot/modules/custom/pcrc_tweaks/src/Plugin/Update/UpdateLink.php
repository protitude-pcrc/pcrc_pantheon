<?php

namespace Drupal\pcrc_tweaks\Plugin\Update;

use Drupal\Core\Url;

class UpdateLink {

    protected $langcode;
    protected $nodes = [];
    protected $languages = [];

    public function __construct($langcode) {
      $this->langcode = $langcode;
    }

    public function convertLinks($text)
    {
      return preg_replace_callback('%<a([^>]+?href="([^"]+?)"[^>]*?)>%i', function($matches) {
        return $this->processLink($matches);
      }, $text);
    }

    protected function processLink($matches) {
      $parts = parse_url($matches[2]);
      // Path has to be relative.
      // Do nothing if the link is not internal (root rel or doc rel).
      // Do nothing if there is no path, either
      if (!array_key_exists('host', $parts) && !empty($parts['path'])) {
        $parts['path'] = trim($parts['path'], '/');
        if (preg_match('@node/(\d+)$@', $parts['path'], $matches2)) {
          $nid = $matches2[1];
          $this->populateLanguages();
          $linkWithTitle = $this->getLinkWithTitle($parts['path'], $matches, $nid);
          $aliasUrl = $this->buildAliasUrl($parts, $nid);
          
          return str_replace($matches[2], $aliasUrl, $linkWithTitle);
        }
      }
      return $matches[0];
    }

    protected function populateLanguages() {
      if (empty($this->languages)) {
        $this->languages = \Drupal::languageManager()->getLanguages();
      }
    }

    protected function getLinkWithTitle($path, $matches, $nid) {
      // If an HTML title attribute already exists...
      if (preg_match('@title="[^"]+?"@', $matches[1])) {
        return $matches[0];
      }

      // Get title of node
      $title = '';
      if (!empty($nid) && !isset($this->nodes[$nid])) {
        $this->nodes[$nid] = \Drupal\node\Entity\Node::load($nid);
      }
      if (isset($this->nodes[$nid])) {
        $title = $this->nodes[$nid]->getTitle();
      }
      if (empty($title)) {
        return $matches[0];
      }
      
      return str_replace($matches[1], $matches[1] . ' title="' . $title . '"', $matches[0]);
    }

    protected function buildAliasUrl($parts, $nid) {
      
      $params = [
        'node' => $nid
      ];
      $options = ['absolute' => FALSE];
      if (!empty($parts['query'])) {
         $options['query'] = $parts['query'];
      }
      if (!empty($parts['fragment'])) {
        $options['fragment'] = $parts['fragment'];
      }
      if (!empty($this->languages[$this->langcode])) {
        $options['language'] = $this->languages[$this->langcode];
      }

      $alias = Url::fromRoute('entity.node.canonical', $params, $options)->toString();
      return str_replace('/index.php', '', $alias);
    }
}