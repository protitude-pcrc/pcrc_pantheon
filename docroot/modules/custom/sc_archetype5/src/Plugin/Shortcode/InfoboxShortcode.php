<?php
/**
 * @file
 * Adds Infobox shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for infobox..
 *
 * @Shortcode(
 *   id = "infobox",
 *   title = @Translation("Infobox"),
 *   description = @Translation("Wraps your content with an accordion div")
 * )
 */
class InfoboxShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',
      'title' => '',  
    ),
      $attributes
    );

    if (!empty($attributes['title'])) {
      $text = "<h3>" . $attributes['title'] . "</h3>" . $text;
    }
    $class = $this->addClass($attributes['class'], 'infobox');
    
    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[infobox title="Info Box Title Here"]</strong>Content Here<strong>[/infobox]</strong>';
    $output[] = '<p>' . t('Adds an infobox with title and content.') . '</p>';
    return implode(' ', $output);
  }
  
}