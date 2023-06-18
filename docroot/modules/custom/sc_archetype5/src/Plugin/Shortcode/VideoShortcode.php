<?php
/**
 * @file
 * Adds div wrapper to sedt color for content.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode to make content small.
 *
 * @Shortcode(
 *   id = "video",
 *   title = @Translation("Video"),
 *   description = @Translation("Embed YouTube or Vimeo video in iframe.")
 * )
 */
class VideoShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'src' => '',  
    ),
      $attributes
    );
    
    return "<iframe src='{$attributes['src']}' frameborder='0' width='16' height='9' allowfullscreen='' mozallowfullscreen=''></iframe>";
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[video src="https://player.vimeo.com/video/123456789" /]</strong>';
    $output[] = '<p>' . t('Embeds a video using an iframe.') . '</p>';
    return implode(' ', $output);
  }
  
}