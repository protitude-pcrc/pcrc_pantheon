<?php
/**
 * @file
 * Adds icon shortcode.
 */

namespace Drupal\sc_archetype5\Plugin\Shortcode;

use Drupal\Core\Language\Language;
use Drupal\shortcode\Plugin\ShortcodeBase;

/**
 * Provides a shortcode for font awesome icons.
 *
 * @Shortcode(
 *   id = "icon",
 *   title = @Translation("Icon"),
 *   description = @Translation("Wraps your content with an accordion div")
 * )
 */
class IconShortcode extends ShortcodeBase {
  
  public function process($attributes, $text, $langcode = Language::LANGCODE_NOT_SPECIFIED) {
    $attributes = $this->getAttributes(array(
      'name' => '',
      'icon_name' => '',  
      'size' => '1',
      'color'   => '',        
    ),
      $attributes
    );

    $class = '';
    $class = $this->addClass($class, 'fa');
    $class = $this->addClass($class, $attributes['color']);
    
    $name = '';
    if (!empty($attributes['name'])){
      $name = $attributes['name'];
    }
    else if (!empty($attributes['icon_name'])){
      $name = $attributes['icon_name'];
    }
    if (!empty($name) && substr($name, 0, 3) !== 'fa-'){
      $name = 'fa-' . $name;
    }
    $class = $this->addClass($class, $name);
    
    if (is_numeric($attributes['size'])){
      $size = floor($attributes['size']);
      switch ($size){
      default:
        $size_class = 'fa-1g';
        break;
      case 2:
      case 3:
      case 4:
      case 5:
        $size_class = 'fa-' . $size . 'x';
        break;
      }
    }
    $class = $this->addClass($class, $size_class);
   
    return "<i class='" . $class . "'></i>";
  }
  
  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    $output = array();
    $output[] = '<strong>[icon name="Icon name" size="3" color="rust" /]</strong>';
    $output[] = '<p>' . t('Creates an icon using font-awesome names.') . '</p>';
    return implode(' ', $output);
  }
  
}