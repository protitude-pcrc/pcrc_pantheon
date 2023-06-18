<?php

namespace Drupal\pcrc_tweaks\EventSubscriber;

use Drupal\Core\EventSubscriber\HttpExceptionSubscriberBase;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;

class RedirectOn403Subscriber extends HttpExceptionSubscriberBase {

  protected $currentUser;

  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  protected function getHandledFormats() {
    return ['html'];
  }

  public function on403(GetResponseForExceptionEvent $event) {
    $request = $event->getRequest();
    $is_anonymous = $this->currentUser->isAnonymous();
    $route_name = $request->attributes->get('_route');
    $is_not_login = $route_name != 'user.login';
    if ($is_anonymous && $is_not_login && $route_name == 'entity.webform.canonical') {
      $webform = $request->attributes->get('webform');
      if ($webform->id() == 'request_data_form') {
        $query = $request->query->all();
        $query['destination'] = Url::fromRoute('<current>')->toString();
        $login_uri = Url::fromRoute('user.login', [], ['query' => $query])->toString();
        $returnResponse = new RedirectResponse($login_uri);
        $event->setResponse($returnResponse);
      }
    }
  }

}

