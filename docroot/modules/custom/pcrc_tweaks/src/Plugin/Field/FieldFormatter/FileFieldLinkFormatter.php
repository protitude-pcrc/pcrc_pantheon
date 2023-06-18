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
use Drupal\Component\Render\FormattableMarkup;

/**
 * Plugin implementation of the 'file_field_download' formatter.
 *
 * @FieldFormatter(
 *   id = "file_field_link",
 *   label = @Translation("File field download link"),
 *   description = @Translation("Displays a link that will download the file."),
 *   field_types = {
 *     "file",
 *     "image"
 *   }
 * )
 */
class FileFieldLinkFormatter extends FileFormatterBase implements ContainerFactoryPluginInterface {

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
   * Constructs a FileDownloadLinkFormatter instance.
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
    $element['link_description'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use file description as link text'),
      '#default_value' => $this->getSetting('link_description'),
    ];
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
    $element['link_secure'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Only allow download to authenticated users'),
      '#default_value' => $this->getSetting('link_secure'),
    ];
    $element['link_secure_redirect'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Redirect anonymous users to login'),
      '#default_value' => $this->getSetting('link_secure_redirect'),
    ];
    $element['link_secure_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Text seen by anonymous users for secure links'),
      '#description' => t('This field supports tokens.'),
      '#default_value' => $this->getSetting('link_secure_text'),
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
    if ($this->getSetting('link_description')) {
      $summary[] = $this->t('Use file description as link text');
    }
    else {
      $summary[] = $this->t('Link text is @title', ['@title' => $this->getSetting('link_text')]);
    }
    if ($this->getSetting('link_target') == '_blank') {
      $summary[] = $this->t('Link opened in new tab.');
    }
    if ($this->getSetting('link_secure')) {
      $summary[] = $this->t('Link only available for authenticated users');
    }
    return $summary;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'link_description' => 0,  
      'link_text' => '[file:name]',
      'link_target' => '',
      'link_secure' => 0,
      'link_secure_redirect' => 0,  
      'link_secure_text' => '',  
    ] + parent::defaultSettings();    
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = array();
    // For token replace, we also want to use the parent entity of the file.
    $parent_entity = $items->getParent()->getValue();
    if (!empty($parent_entity)) {
      $parent_entity_type = $parent_entity->getEntityType()->id();
      $token_data[$parent_entity_type] = $parent_entity;
    }
    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $file) {
      // Prepare the text and the URL of the link.
      $token_data['file'] = $file;
      if ($this->getSetting('link_description')) {
        $link_text = $file->_referringItem->description;
        if (empty($link_text)) {
          $link_text = $file->getFilename();
        }
      }
      else {
        $link_text = $this->token->replace($this->getSetting('link_text'), $token_data);
      }
      
      if ($this->getSetting('link_secure') && \Drupal::currentUser()->isAnonymous()) {
        $secure_link_text = $this->token->replace($this->getSetting('link_secure_text'), $token_data);
        if ($this->getSetting('link_secure_redirect')){
          $elements[$delta] = [
            '#type' => 'link',
            '#url' => Url::fromRoute('user.page'),
            '#title' => new FormattableMarkup('@link_text <span class="field--link-secure">' . $secure_link_text . '</span>', ['@link_text' => $link_text]),
          ];
        }
        else {
          $elements[$delta]['#markup'] = '<span class="field--type-file">' . $link_text . '</span>';
          $elements[$delta]['#markup'] .= '<span class="field--link-secure">' . $secure_link_text . '</span>';
        }
      }
      else {
        $elements[$delta] = [
          '#type' => 'link',
          '#url' => Url::fromRoute('pcrc_tweaks.file_download', ['fid' => $file->id()]),
          '#title' => $link_text,
        ];
        if ($this->getSetting('link_target') !== 'inline') {
          $elements[$delta]['#attributes']['target'] = $this->getSetting('link_target');
        }
      }
      
      $this->renderer->addCacheableDependency($elements[$delta], $file);
    }

    return $elements;
  }

}
