<?php
/**
 * @file
 * Adds div wrapper to sedt color for content.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode to hide content.
 *
 * @Shortcode(
 *   id = "color",
 *   title = @Translation("Color"),
 *   description = @Translation("Adds content within a div that can be colored.")
 * )
 */
class ColorShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'color' => '',
      'background' => '',  
    ),
      $attributes
    );
    
    $class = '';
    $class = $this->addClass($class, 'color');
    $class = $this->addClass($class, $attributes['color']);
    $class = $this->addClass($class, 'back-' . $attributes['background']);
    
    return "<span class='$class'>$text</span>";
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[color color="rust" background="yellow"]</strong>Content to be displayed a certain color here<strong>[/hide]</strong>';
    $output[] = '<p>' . t('Wraps your content with a tag so that it is displayed a certain color.') . '</p>';
    return implode(' ', $output);
  }
  
}