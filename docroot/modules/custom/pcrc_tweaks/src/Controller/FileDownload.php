<?php
/**
 * @file
 * Contains \Drupal\pcrc_tweaks\Controller\FileDownload.
 */
namespace Drupal\pcrc_tweaks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Component\Utility\UrlHelper;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use \Drupal\Component\Utility\Crypt;
use Drupal\file\Entity\File;
use Drupal\Core\StreamWrapper\StreamWrapperManager;

/**
* Displays an empty home page
*/
class FileDownload extends ControllerBase {
  
  public function display($fid) {
    $fid  = intval($fid);
    $file = File::load($fid);

    if (empty($fid) || empty($file) || !$file->get('status')->value || !file_exists($file->getFileUri())) {
      throw new NotFoundHttpException();
    }

    $file_uri = $file->getFileUri();
    $scheme = StreamWrapperManager::getScheme($file_uri);
    $target = StreamWrapperManager::getTarget($file_uri);

    // Render Image Style preset if applicable.
    $uri = UrlHelper::parse(\Drupal::request()->getRequestUri());
    if (!empty($uri['query']) && !empty($uri['query']['style']) && strpos($file->getMimeType(), 'image') === 0) {
      $image_style = \Drupal::entityTypeManager()->getStorage('image_style')->load($uri['query']['style']);
      if ($image_style) {
        $derivative_uri = $image_style->buildUri($file_uri);
        // Don't start generating the image if the derivative already exists or if
        // generation is in progress in another thread.
        if (!file_exists($derivative_uri)) {
          $lock_name = 'image_style_deliver:' . $image_style->id() . ':' . Crypt::hashBase64($file_uri);
          $lock_acquired = \Drupal::lock()->acquire($lock_name);
          if (!$lock_acquired) {
            // Tell client to retry again in 3 seconds. Currently no browsers are
            // known to support Retry-After.
            throw new ServiceUnavailableHttpException(3, $this->t('Image generation in progress. Try again shortly.'));
          }
        }
      
        // Try to generate the image, unless another thread just did it while we
        // were acquiring the lock.
        $success = file_exists($derivative_uri) || $image_style->createDerivative($file_uri, $derivative_uri);

        if (!empty($lock_acquired)) {
          \Drupal::lock()->release($lock_name);
        }

        if ($success) {
          $file_uri = $derivative_uri;
        }
        else {
          return new Response($this->t('Error generating image.'), 500);
        }
      }
    }

    $headers = array(
      'Content-Type' => $file->getMimeType(),  
      'Content-Length' => $file->get('filesize')->value,
      'Content-Transfer-Encoding' => 'binary',
      'Pragma' => 'no-cache',
      'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
      'Expires' => '0',
      'Accept-Ranges' => 'bytes',
      'Content-Disposition' => 'inline; filename="' . $file->get('filename')->value . '"',
    );
    if (!empty($uri['query']) && !empty($uri['query']['download']) && $uri['query']['download'] == 'true'){
      $headers['Content-Type'] = 'force-download';
      $headers['Content-Disposition'] = 'attachment; filename="' . $file->get('filename')->value . '"';
    }
    return new BinaryFileResponse($file_uri, 200, $headers, $scheme !== 'private');
  }

}
