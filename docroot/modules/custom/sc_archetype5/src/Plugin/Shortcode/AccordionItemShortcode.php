<?php
/**
 * @file
 * Adds an accordion item shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for accordion items.
 *
 * @Shortcode(
 *   id = "accordion-item",
 *   title = @Translation("Accordion Item"),
 *   description = @Translation("Adds the accordion item into the parent accordion")
 * )
 */
class AccordionItemShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'title'  => '', 
    ),
      $attributes
    );
    
    return '{start-item}<h3>' . $attributes['title'] . '</h3><div>' . $text . '</div>{end-item}';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[accordion-item title="Accordian Title Here" ]</strong>Content Here<strong>[/accordion-item]</strong>';
    $output[] = '<p>' . t('Adds an item to your accordion.') . '</p>';
    return implode(' ', $output);
  }
  
}