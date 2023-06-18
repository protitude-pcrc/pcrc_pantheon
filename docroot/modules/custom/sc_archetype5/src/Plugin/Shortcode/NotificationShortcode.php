<?php
/**
 * @file
 * Adds notification shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for notifications.
 *
 * @Shortcode(
 *   id = "notification",
 *   title = @Translation("Notification"),
 *   description = @Translation("Wraps your content with a notification div")
 * )
 */
class NotificationShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',
      'bold' => '',
      'color' => '',
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'notification');
    $class = $this->addClass($class, $attributes['color']);
    
    //return '<div class="' . $class . '" ><p><strong>' . $attributes['bold'] . '</strong>' . $text . '</p></div>';
    return '<div class="' . $class . '" ><div class="icon"><i class="fa"></i></div><p><strong>' . $attributes['bold'] . '</strong>' . $text . '</p></div>';
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[notification bold="Bold Text Here" color="notification-red"]</strong>Content Here<strong>[/notification]</strong>';
    $output[] = '<p>' . t('Wraps your content with a notification div.') . '</p>';
    return implode(' ', $output);
  }
  
}