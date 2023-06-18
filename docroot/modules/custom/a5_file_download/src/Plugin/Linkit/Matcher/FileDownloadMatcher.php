<?php

/**
 * @file
 * Contains \Drupal\a5_file_download\Plugin\Linkit\Matcher\FileDownloadMatcher.
 */

namespace Drupal\a5_file_download\Plugin\Linkit\Matcher;

use Drupal\linkit\Plugin\Linkit\Matcher\FileMatcher;

/**
 * @Matcher(
 *   id = "entity:filed",
 *   target_entity = "file",
 *   label = @Translation("File Download"),
 *   provider = "file"
 * )
 */
class FileDownloadMatcher extends FileMatcher {
  
  /**
   * {@inheritdoc}
   *
   * Create a download link for the file
   */
  protected function buildPath($entity) {
    /** @var \Drupal\file\FileInterface $entity */
    return '/file/download/' . $entity->id();
  }
  
}