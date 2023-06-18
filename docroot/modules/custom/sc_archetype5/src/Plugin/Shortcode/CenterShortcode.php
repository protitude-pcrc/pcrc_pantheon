<?php
/**
 * @file
 * Adds a div that can be used to center content
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for centering content.
 *
 * @Shortcode(
 *   id = "center",
 *   title = @Translation("Center"),
 *   description = @Translation("Wraps your content with a div so that it can be centered")
 * )
 */
class CenterShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    return '<div class="sc-center">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[center]</strong>Content to align<strong>[/center]</strong>';
    $output[] = '<p>' . t('Wraps your content with a div to center content.') . '</p>';
    return implode(' ', $output);
  }
  
}