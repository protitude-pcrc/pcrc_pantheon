<?php
/**
 * @file
 * Adds tags to highlight block as code.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for code blocks.
 *
 * @Shortcode(
 *   id = "code",
 *   title = @Translation("Code"),
 *   description = @Translation("Adds tags so block can appear as code")
 * )
 */
class CodeShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    return '<pre>' . $text . '</pre>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[code]</strong>Content Here<strong>[/code]</strong>';
    $output[] = '<p>' . t('Wraps your content with a tag to appear as a code block.') . '</p>';
    return implode(' ', $output);
  }
  
}