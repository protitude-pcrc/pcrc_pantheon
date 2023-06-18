<?php
/**
 * @file
 * Adds teaser div wrapper.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for teaser.
 *
 * @Shortcode(
 *   id = "teaser",
 *   title = @Translation("Teaser"),
 *   description = @Translation("Wraps your content with a teaser div")
 * )
 */
class TeaserShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',  
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'teaser');
    
    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[teaser]</strong>Content Here<strong>[/teaser]</strong>';
    $output[] = '<p>' . t('Wraps your content with a teaser div.') . '</p>';
    return implode(' ', $output);
  }
  
}