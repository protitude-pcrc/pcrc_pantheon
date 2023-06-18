<?php
/**
 * @file
 * Adds toggle div wrapper.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for toggles.
 *
 * @Shortcode(
 *   id = "toggle",
 *   title = @Translation("Toggle"),
 *   description = @Translation("Wraps your content with a toggle div")
 * )
 */
class ToggleShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',  
    ),
      $attributes
    );

    $text = _sc_archetype5_clean_items($text);
    $class = $this->addClass($attributes['class'], 'toggle');
    
    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[toggle]</strong>[toggle-item][/toggle-item]<strong>[/toggle]</strong>';
    $output[] = '<p>' . t('Wraps your content with a toggle div.') . '</p>';
    return implode(' ', $output);
  }
  
}