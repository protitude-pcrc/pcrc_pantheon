<?php

namespace Drupal\pcrc_tweaks\Plugin\Field\FieldFormatter;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Utility\Token;
use Drupal\file\Plugin\Field\FieldFormatter\FileFormatterBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'file_uri_link' formatter.
 *
 * @FieldFormatter(
 *   id = "file_uri_link",
 *   label = @Translation("File URI link"),
 *   description = @Translation("Displays a link that will display the file."),
 *   field_types = {
 *     "uri",
 *     "file_uri"
 *   }
 * )
 */
class FileLinkFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $module_handler;

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * Constructs a FileLinkFormatter instance.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings settings.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param Drupal\Core\Render\RendererInterface $renderer
   *   The rendered service
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, RendererInterface $renderer, ModuleHandlerInterface $module_handler, Token $token) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->renderer = $renderer;
    $this->module_handler = $module_handler;
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('renderer'),
      $container->get('module_handler'),
      $container->get('token')
    );
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
    $element['link_target'] = [
      '#title' => $this->t('Link target'),
      '#description' => $this->t('Select the where this link will open.'),
      '#type' => 'select',
      '#options' => ['inline' => 'In same window', '_blank' => 'In new window'],
      '#default_value' => $this->getSetting('link_target'),
    ];
    // If we have the token module available, add the token tree link.
    if ($this->module_handler->moduleExists('token')) {
      $token_types = array('file');
      if (!empty($form['#entity_type'])) {
        $token_types[] = $form['#entity_type'];
      }
      $element['token_tree_link'] = array(
        '#theme' => 'token_tree_link',
        '#token_types' => $token_types,
      );
    }
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = $this->t('Link text is @title', ['@title' => $this->getSetting('link_text')]);
    if ($this->getSetting('link_target') == '_blank') {
      $summary[] = $this->t('Link opened in new tab.');
    }
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'link_text' => '[file:name]',
      'link_target' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      if (!$item->isEmpty()) {
        $file = $item->getEntity();
        // Prepare the text and the URL of the link.
        $token_data['file'] = $file;
        $link_text = $this->token->replace($this->getSetting('link_text'), $token_data);

        $elements[$delta] = [
          '#type' => 'link',
          '#url' => Url::fromUri(\Drupal::service('file_url_generator')->generateAbsoluteString($item->value)),
          '#title' => $link_text,
          '#attributes' => ['type' => $file->getMimeType() . '; length=' . $file->getSize()],
        ];
        if ($this->getSetting('link_target') !== 'inline') {
          $elements[$delta]['#attributes']['target'] = $this->getSetting('link_target');
        }

        $this->renderer->addCacheableDependency($elements[$delta], $file);
      }
    }

    return $elements;
  }

}
