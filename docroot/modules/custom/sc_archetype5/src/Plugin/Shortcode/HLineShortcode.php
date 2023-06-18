<?php
/**
 * @file
 * Adds a horizontal line with code and size.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for code blocks.
 *
 * @Shortcode(
 *   id = "hline",
 *   title = @Translation("Horizontal Line"),
 *   description = @Translation("Adds a horizontal line")
 * )
 */
class HLineShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',
      'size'    => '',
      'color'   => '',  
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'hline');
    $class = $this->addClass($class, $attributes['size']);
    $class = $this->addClass($class, $attributes['color']);
    
    return "<hr class='$class' />";
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[hline size="thick|normal|thin" color="yellow" /]</strong>';
    $output[] = '<p>' . t('Displays a horizontal line of given thickness and color.') . '</p>';
    return implode(' ', $output);
  }
  
}