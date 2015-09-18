<?php

/**
 * @file
 * Contains \Drupal\mtg_import\Plugin\Action\AddInstance.php.
 */

namespace Drupal\mtg_import\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Adds a card instance.
 *
 * @Action(
 *   id = "mtg_import_add_instance_action",
 *   label = @Translation("Add an instance of the selected card(s)"),
 *   type = "node"
 * )
 */
class AddInstance extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($object = NULL) {
    dpm($object);
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    $access = AccessResult::allowed();
    return $return_as_object ? $access : $access->isAllowed();
  }

}
