<?php

namespace Drupal\pcrc_tweaks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * A controller that redirects to the current user's pages.
 */
class AccountRedirect extends ControllerBase {
  
  /**
   * Redirect to user edit page
   */
  public function redirect_account_edit() {    
    $route_name = 'entity.user.edit_form';
    $route_parameters = [
      'user' => \Drupal::currentUser()->id(),
    ];
    return $this->redirect($route_name, $route_parameters);
  }

  /**
   * Redirect to user page
   */
  public function redirect_account_view() {    
    $route_name = 'entity.user.canonical';
    $route_parameters = [
      'user' => \Drupal::currentUser()->id(),
    ];
    return $this->redirect($route_name, $route_parameters);
  }
  
}

