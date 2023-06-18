<?php
/**
 * @file
 * Contains \Drupal\sc_archetype5\Plugin\Filter\ShortcodePreprocessor.
 */

namespace Drupal\sc_archetype5\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Filter that corrects html added by wysiwyg editors around shortcodes.
 *
 * @Filter(
 *   id = "shortcode_preprocessor",
 *   module = "sc_archetype5",
 *   title = @Translation("Shortcodes - html pre-processor"),
 *   description = @Translation("Remove spurious characters from inside shortcode tags. Run before shortcode filter. Enable only if you using wysiwyg editor."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class ShortcodePreprocessor extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    if (!empty($text)) {
      $text = preg_replace_callback(
        '|\[([^\]]+)\]|is',
        function($matches){
          // replace characters with [] tag
          $return =  str_replace(array('&nbsp;', '"/]', "'/]"), array(' ', '" /]', "' /]"), $matches[0]);
          $return = preg_replace('|href="([^"]+)"|', "href='$1'", $return);
          return $return;
        },
        $text
      );
    }
    
    return new FilterProcessResult($text);
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    return '';
  }
}
