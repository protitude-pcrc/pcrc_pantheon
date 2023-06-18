<?php

namespace Drupal\pcrc_tweaks\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin extended implementation of the 'email_mailto' formatter.
 *
 * @FieldFormatter(
 *   id = "ext_email_mailto",
 *   label = @Translation("Ext Email"),
 *   field_types = {
 *     "email"
 *   }
 * )
 */
class ExtEmailFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'link_text' => '',
    ] + parent::defaultSettings();
  }
  
    /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::settingsForm($form, $form_state);
    $element['link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#description' => t('This field supports tokens.'),
      '#default_value' => $this->getSetting('link_text'),
    ];

    return $element;
  }
  
  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $settings = $this->getSettings();

    if (!empty($settings['link_text'])) {
      $summary[] = $this->t('Link text is @title', ['@title' => $settings['link_text']]);
    }
    
    return $summary;
  }
  
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $settings = $this->getSettings();
    
    foreach ($items as $delta => $item) {
      if (!empty($settings['link_text'])) {
        $title = $settings['link_text'];
      }
      else {
        $title = $item->value;
      }
      $elements[$delta] = [
        '#type' => 'link',
        '#title' => $title,
        '#url' => Url::fromUri('mailto:' . $item->value),
      ];
    }

    return $elements;
  }

}

