<?php
/**
 * @file
 * Adds tooltip shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Drupal\Component\Utility\Html;

/**
 * Provides a shortcode for tooltips.
 *
 * @Shortcode(
 *   id = "tooltip",
 *   title = @Translation("Tooltip"),
 *   description = @Translation("Wraps your content so it acts like a tooltip")
 * )
 */
class TooltipShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    global $base_url;
    
    $attributes = $this->getAttributes(array(
      'title' => '',
      'description' => '',
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'tooltip-link');
    
    if (!empty($attributes['title'])){
      $title = HTML::escape($attributes['title']);
    }
    else {
      $title = '';
    }

    $popover = '';
    if ($attributes['description']) {
      $popover = '<span class="tooltip-popover">';
      if (!empty($title)){
        $popover .= '<span class="tooltip-title">' . $title . '</span>';
      }
      $popover .= '<span class="tooltip-desc">' . strip_tags($attributes['description']) . '</span>';
      $popover .= '</span>';
    }
    
    return '<span class="' . $class . '">' . $text . $popover . '</span>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[tooltip title="title here" description="description here"]</strong>Content Here<strong>[/tooltip]</strong>';
    $output[] = '<p>' . t('Wraps your content so it acts like a tooltip.') . '</p>';
    return implode(' ', $output);
  }
  
}
