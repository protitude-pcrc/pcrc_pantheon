<?php
/**
 * @file
 * Adds classes to create grid columns.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for creating basic grid columns.
 *
 * @Shortcode(
 *   id = "col",
 *   title = @Translation("Columns"),
 *   description = @Translation("Adds classes to create column grid")
 * )
 */
class ColumnsShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',
      'width'      => '',
      'align'      => '',
      'last'       => '',
      'clear'      => '',        
    ),
      $attributes
    );

    $class = $attributes['class'];
    if ($attributes['last']) $class = $this->addClass($class, 'col-last');
    if ($attributes['width']) $class = $this->addClass($class, 'col-' . $attributes['width']);
    if ($attributes['align'] == 'right') $class = $this->addClass($class, 'float-right');
    if ($attributes['align'] == 'center') $class = $this->addClass($class, 'align-center');
    if ($attributes['clear']) $class = $this->addClass($class, 'clear-both');

    return '<div class="' . $class . '">' . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[col width="1-2"]</strong>Content Here<strong>[/col][col width="1-2" last="yes"]</strong>Content here<strong>[/col]</strong>';
    $output[] = '<p>' . t('Create grid columns across the page.') . '</p>';
    return implode(' ', $output);
  }
  
}