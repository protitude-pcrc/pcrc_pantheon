<?php
/**
 * @file
 * Adds a toggle item shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for toggle items.
 *
 * @Shortcode(
 *   id = "toggle-item",
 *   title = @Translation("Toggle Item"),
 *   description = @Translation("Adds the toggle item into the parent toggle")
 * )
 */
class ToggleItemShortcode extends ShortcodeBase {

  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'title'  => '',
    ),
      $attributes
    );

    return '{start-item}<details><summary>' . $attributes['title'] . '</summary><div>' . $text . '</div></details>{end-item}';
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[toggle-item title="Toggle Title Here" ]</strong>Content Here<strong>[/toggle-item]</strong>';
    $output[] = '<p>' . t('Adds an item to your toggle.') . '</p>';
    return implode(' ', $output);
  }

}
