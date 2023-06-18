<?php
/**
 * @file
 * Adds accordion div wrapper.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for accordions.
 *
 * @Shortcode(
 *   id = "accordion",
 *   title = @Translation("Accordion"),
 *   description = @Translation("Wraps your content with an accordion div")
 * )
 */
class AccordionShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',  
    ),
      $attributes
    );

    $text = _sc_archetype5_clean_items($text);
    $class = $this->addClass($attributes['class'], 'accordion');
    
    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[accordion]</strong>[accordion-item][/accordion-item]<strong>[/accordion]</strong>';
    $output[] = '<p>' . t('Wraps your content with an accordion div.') . '</p>';
    return implode(' ', $output);
  }
  
}