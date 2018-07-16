<?php

namespace Drupal\wunderhugs;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Hug entity.
 *
 * @see \Drupal\wunderhugs\Entity\Hug.
 */
class HugAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\wunderhugs\Entity\HugInterface $entity */
    switch ($operation) {
      case 'view':
        if ($entity->isPublished()) {
          if ($account->id() == $entity->getOwnerId()) {
            return AccessResult::allowedIfHasPermission($account, 'view own published hug entities');
          }
          else {
            if ($account->id() == $entity->isReceiver()) {
              return AccessResult::allowedIfHasPermission($account, 'view received published hug entities');
            }
            else {
              return AccessResult::allowedIfHasPermission($account, 'view all published hug entities');
            }
          }
        }
        else {
          if ($account->id() == $entity->getOwnerId()) {
            return AccessResult::allowedIfHasPermission($account, 'view own unpublished hug entities');
          }
          else {
            return AccessResult::allowedIfHasPermission($account, 'view all unpublished hug entities');
          }
        }

      case 'update':
        if ($account->id() == $entity->getOwnerId()) {
          return AccessResult::allowedIfHasPermission($account, 'edit own hug entities');
        }
        else {
          return AccessResult::allowedIfHasPermission($account, 'edit all hug entities');
        }
      case 'delete':
        if ($account->id() == $entity->getOwnerId()) {
          return AccessResult::allowedIfHasPermission($account, 'delete own hug entities');
        }
        else {
          return AccessResult::allowedIfHasPermission($account, 'delete all hug entities');
        }
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add hug entities');
  }

}
