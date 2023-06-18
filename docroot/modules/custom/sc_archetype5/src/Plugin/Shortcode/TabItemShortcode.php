<?php
/**
 * @file
 * Adds an tab item shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for accordion items.
 *
 * @Shortcode(
 *   id = "tab-item",
 *   title = @Translation("Tab Item"),
 *   description = @Translation("Adds the tab item into the parent tab")
 * )
 */
class TabItemShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'title'  => '', 
    ),
      $attributes
    );
    
    return '{start-item}<div {processtab|' . $attributes['title'] . '} >' . $text . '</div>{end-item}';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[tab-item title="Tab Title Here" ]</strong>Content Here<strong>[/tab-item]</strong>';
    $output[] = '<p>' . t('Adds a tab to your tabs container.') . '</p>';
    return implode(' ', $output);
  }
  
}