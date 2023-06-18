<?php

namespace Drupal\pcrc_tweaks\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Allow custom config settings.
 *
 * @CKEditorPlugin(
 *   id = "customck",
 *   label = @Translation("Custom CKEditor plugin")
 * )
 */
class CustomCK extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface, ContainerFactoryPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return array();
  }
  
  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {

    $config = parent::getConfig($editor);

    // Put your custom configs here.
    //$config['allowedContent'] = TRUE;
    $config['extraPlugins'] = 'remlink';
    kint($config);
    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'pcrc_tweaks') . '/js/plugins/plugin.js';
  }
  
}

