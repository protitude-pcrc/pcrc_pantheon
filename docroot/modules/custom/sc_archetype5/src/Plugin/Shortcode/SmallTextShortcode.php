<?php
/**
 * @file
 * Adds div wrapper to sedt color for content.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode to make content small.
 *
 * @Shortcode(
 *   id = "small",
 *   title = @Translation("Small Text"),
 *   description = @Translation("Adds content within a div that can be sized to be smaller.")
 * )
 */
class SmallTextShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'size' => '50',
    ),
      $attributes
    );
    
    $size = filter_var($attributes['size'], FILTER_SANITIZE_NUMBER_INT);
    $size = floor($size/10) * 10;
            
    $class = 'small';
    $class = $this->addClass($class, 'size-' . $size);
    
    return "<div class='$class'>$text</div>";
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[small size="60%"]</strong>Content to be displayed a size<strong>[/small]</strong>';
    $output[] = '<p>' . t('Wraps your content with a tag so that it is displayed a certain size relative to other content.') . '</p>';
    return implode(' ', $output);
  }
  
}