<?php
/**
 * @file
 * Adds wrapper div to create footnote.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for footnotes.
 *
 * @Shortcode(
 *   id = "fn",
 *   title = @Translation("Footnote"),
 *   description = @Translation("Formats the content as a footnote")
 * )
 */
class FootnoteShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',  
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'footnote');
    
    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[fn]</strong>Content Here<strong>[/fn]</strong>';
    $output[] = '<p>' . t('Formats your content as a footnote.') . '</p>';
    return implode(' ', $output);
  }
  
}