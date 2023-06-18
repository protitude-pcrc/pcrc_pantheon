<?php
/**
 * @file
 * Adds div wrapper to hide content.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode to hide content.
 *
 * @Shortcode(
 *   id = "hide",
 *   title = @Translation("Hide"),
 *   description = @Translation("Adds content within a div that can be hidden")
 * )
 */
class HideShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    return '<span class="hidden">' . $text . '</span>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[hide]</strong>Content to be hidden here<strong>[/hide]</strong>';
    $output[] = '<p>' . t('Wraps your content with a tag so that it is hidden from view.') . '</p>';
    return implode(' ', $output);
  }
  
}