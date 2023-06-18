<?php

namespace Drupal\pcrc_tweaks\Plugin\Filter;

use Drupal\filter\Plugin\FilterBase;
use Drupal\filter\FilterProcessResult;
use Drupal\pcrc_tweaks\Plugin\Update\UpdateLink;

/**
 * @Filter(
 *   id = "filter_intlinks",
 *   title = @Translation("Internal Links Filter"),
 *   description = @Translation("Identifies internal links in content and adds an HTML 'title' attribute (if none already exists), using the linked node's node title. Also re-writes links to 'normal Drupal paths' (e.g. node/123) as path alias if an alias exists."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class FilterIntlinks extends FilterBase { 
  public function process($text, $langcode) {
    $linkUpdater = new UpdateLink($langcode);
    $text = $linkUpdater->convertLinks($text);
    return new FilterProcessResult($text);
  }
}