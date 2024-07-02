<?php
/**
 * @file
 * Creates an button shortcode backward compatible with A5 sites
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;

/**
 * Provides a shortcode for buttons.
 *
 * @Shortcode(
 *   id = "buttona5",
 *   title = @Translation("Button A5"),
 *   description = @Translation("Insert link formatted like a button")
 * )
 */
class ButtonA5Shortcode extends ShortcodeBase {

  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'class' => '',
      'url'     => '',
      'size'    => '',
      'color'   => '',
      'target'  => '',
      'float' => '',
      'style' => 'solid',
    ),
      $attributes
    );

    $class = $this->addClass($attributes['class'], 'button');
    $class = $this->addClass($class, $attributes['size']);
    $class = $this->addClass($class, $attributes['color']);
    $class = $this->addClass($class, $attributes['float']);
    $class = $this->addClass($class, $attributes['style']);

    if (empty($attributes['url']) || $attributes['url'] == '#'){
      $attributes['url'] = '<front>';
    }

    $markup = Markup::create("<span class='button-outline-top'><span class='button-outline-bottom'><span class='button-text-wrapper'>" . $text . "</span></span></span>");

    // Get route name.
    if ($url = \Drupal::service('path.validator')->getUrlIfValid(ltrim($attributes['url'], '/'))) {
      $link = Link::fromTextAndUrl($markup, $url);
      $link = $link->toRenderable();
      $link['#attributes'] = array('class' => explode(' ', $class), 'target' => $attributes['target']);
    }
    else {
      $link = [
        '#markup' => $markup,
        '#prefix' => "<div class='$class'>",
        '#suffix'  => '</div>',
      ];
    }
    return \Drupal::service('renderer')->render($link);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[button url="#" size="small" color="red" target="_blank" style="solid|stroke"]</strong>Button Text<strong>[/button]</strong>';
    if ($long) {
      $output[] = '<p>' . t('Creates a button link. All paramters are optional. Size can be xsmall, small, large.') . '</p>';
    }
    else {
      $output[] = '<p>' . t('Creates a button link.') . '</p>';
    }
    return implode(' ', $output);
  }

}
