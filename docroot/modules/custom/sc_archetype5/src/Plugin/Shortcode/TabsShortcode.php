<?php
/**
 * @file
 * Adds tabs div wrapper.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for tabs.
 *
 * @Shortcode(
 *   id = "tabs",
 *   title = @Translation("Tabs"),
 *   description = @Translation("Wraps your content with a tabs div")
 * )
 */
class TabsShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    global $sc_tab_count;
    
    $attributes = $this->getAttributes(array(
      'class' => '',  
    ),
      $attributes
    );

    $tempcount = $sc_tab_count;
    preg_match_all ( "/{processtab\|(.+?)}/" , $text , $matches);
    $links = array();
    foreach($matches[1] as $match) {
      $tempcount ++;
      $links[] = '<li><a href="#tabs-' . $tempcount . '">' . $match . '</a></li>' ;
    }
    $tablinks = "<ul>" . implode("",$links) . "</ul>";
    
    $text = preg_replace_callback(
      "/{processtab\|.+?}/", 
      function($matches){
        global $sc_tab_count;
        $sc_tab_count++;
        return 'id="tabs-'. $sc_tab_count .'"';
      },
      $text
    );
    $text = _sc_archetype5_clean_items($text);
    $class = $this->addClass($attributes['class'], 'sc-tabs');
    
    return '<div class="' . $class . '">' . $tablinks  . $text . '</div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[tabs]</strong>[tab-item][/tab-item]<strong>[/tabs]</strong>';
    $output[] = '<p>' . t('Wraps your content with a tabs div.') . '</p>';
    return implode(' ', $output);
  }
  
}