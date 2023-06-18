<?php
/**
 * @file
 * Adds word rotate shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Html;

/**
 * Provides a shortcode for tooltips.
 *
 * @Shortcode(
 *   id = "wordrotate",
 *   title = @Translation("Word Rotate"),
 *   description = @Translation("Rotates a list of words")
 * )
 */
class WordRotateShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    
    $attributes = $this->getAttributes(array(
      'words' => '',
      'delay' => '2000',
      'transition' => '300',  
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'word-rotate');
    
    $word_text = '';
    if (!empty($attributes['words'])){
      $words = explode('|', $attributes['words']);
      foreach ($words as $word){
        $word_text .= '<span>' . HTML::escape($word) . '</span>';
      }
    }
    
    $options = [];
    if (!empty($attributes['delay'])){
      $options['delay'] = $attributes['delay'];
    }
    if (!empty($attributes['transition'])){
      $options['animDelay'] = $attributes['transition'];
    }
    
    $output = "<span class='" . $class . "' data-plugin-options='" . Json::encode($options) . "'><span class='word-rotate-items'>" . $word_text . '</span></span>';
    return $output;
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[wordrotate words="incredibly|especially|extremely" delay="2000" transition="300" /]</strong>';
    $output[] = '<p>' . t('Create a display showing rotating words.') . '</p>';
    return implode(' ', $output);
  }
  
}
