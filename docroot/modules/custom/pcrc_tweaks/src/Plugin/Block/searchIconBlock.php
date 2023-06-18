<?php

namespace Drupal\pcrc_tweaks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a SEarch Icon Block.
 *
 * @Block(
 *   id = "search_icon_block",
 *   admin_label = @Translation("Search Icon block"),
 * )
 */
class SearchIconBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block = "<div class='pcrc-search-icon'><i class='fa fa-search'></i></div>";
    return array(
      '#markup' => $block,
    );
  }

}

