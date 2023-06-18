<?php

namespace Drupal\pcrc_migrate\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Maps name field values to D8 values.
 *
 * @MigrateProcessPlugin(
 *   id = "namefield"
 * )
 */
class NameField extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $row_values = $row->getSource();
    $parsed = [
      'given' => $row_values['firstname'],
      'family' => $row_values['lastname'],
    ];
    return $parsed;
  }

}
