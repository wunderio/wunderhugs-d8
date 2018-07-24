<?php

namespace Drupal\wunderhugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
//use Drupal\Core\Url;
use Drupal\wunderhugs\Entity\Hug;

/**
 * Provides a 'UserPageHugFormBlock' block.
 *
 * @Block(
 *  id = "user_page_hug_form_block",
 *  admin_label = @Translation("User page hug form"),
 * )
 */
class UserPageHugFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    // Check if we're on a profile page.
    $route_name = \Drupal::routeMatch()->getRouteName();
    if ($route_name == 'entity.user.canonical') {
      // Check we're not on the logged-in user's own profile page.
      $current_user = \Drupal::currentUser();
      $page_user = \Drupal::routeMatch()->getParameter('user');
      if (isset($page_user) && isset($current_user)) {
        if ($current_user->id() != $page_user->id()) {
          $entity = Hug::create();
          $form = \Drupal::service('entity.form_builder')->getForm($entity, 'default');
          $form['field_hug_receiver']['widget'][0]['target_id']['#default_value'] = $page_user;
          $field_name = $page_user->getAccountName() . ' (' . $page_user->id() . ')';
          $form['field_hug_receiver']['widget'][0]['target_id']['#value'] = $field_name;
          $build = $form;
        }
      }
    }
    // If we're not on a profile page, show a message.
    else {
      $build['user_hug_status_block']['#markup'] = '<p>' . t('This block needs to be placed on a user profile page.') . '</p>';
    }

    return $build;
  }

}
