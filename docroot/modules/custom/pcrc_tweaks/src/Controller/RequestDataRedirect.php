<?php

namespace Drupal\pcrc_tweaks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * A controller that redirects the user to request data form
 * or user login depending on role.
 */
class RequestDataRedirect extends ControllerBase {
  
  /**
   * Redirect to request data form if authenticated user
   * otherwise redirect to user login
   */
  public function redirect_request_data() {
    $route_name = 'entity.webform.canonical';
    $route_parameters = ['webform' => 'request_data_form'];
    if (\Drupal::currentUser()->isAnonymous()) {
      $destination = URL::fromRoute($route_name, $route_parameters)->toString();
      $route_name = 'user.login';
      $route_parameters = ['destination' => $destination];
    }
    return $this->redirect($route_name, $route_parameters);
  }
  
}

