<?php

namespace Drupal\pcrc_tweaks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\views\Views;

/**
 * Provides a View Header Block.
 *
 * @Block(
 *   id = "view_header_block",
 *   admin_label = @Translation("View header block"),
 * )
 */
class ViewHeaderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_route_name = \Drupal::service('current_route_match')->getRouteName();
    if (substr($current_route_name, 0, 4) == 'view') {
      $parts = explode('.', $current_route_name);
      $view = Views::getView($parts[1]);
      $title = '';
      $header = '';
      if (is_object($view)) {
        $view->setDisplay($parts[2]);
        $view->preExecute();
        $view->execute();
        $title = "<h1 class='page-title'>" . $view->getTitle() . "</h1>";
        if (!empty($view->display_handler->handlers['header']['area'])) {
          $header = $view->display_handler->handlers['header']['area']->render();
          $header['#prefix'] = "<div class='subtitle'>";
          $header['#suffix'] = '</div>';
        }
      }
      return [
        'title' => ['#markup' => $title],
        //'subtitle' => $header,
      ];
    }
  }

  /**
    * {@inheritdoc}
    */
  public function getCacheMaxAge() {
    return 0;
  }

}

