<?php

namespace Drupal\wunderhugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'UserHugCountBlock' block.
 *
 * @Block(
 *  id = "user_hug_count_block",
 *  admin_label = @Translation("User hug count block"),
 * )
 */
class UserHugCountBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $content = '';
    $user = \Drupal::currentUser();

    // Fetch the dates for the current hug window.
    $hug_window = wunderhugs_check_hug_window(time());

    // Fetch maximum allowed hugs.
    $config = \Drupal::config('wunderhugs.adminsettings');
    $max_hugs = $config->get('maximum_hugs_per_window');

    // Hide some info if user is not logged in.
    if (isset($user) && $user->id() > 0) {

      // Fetch no of hugs in this window and work out remainder.
      $hug_count = wunderhugs_fetch_hug_count($user->id(), $hug_window['start'], $hug_window['end']);
      $hugs_remaining = $max_hugs - $hug_count;
      $content .= \Drupal::translation()->formatPlural($hugs_remaining, '<span>1 hug left</span>', '<span>@count hugs left</span>');
    }

    $build['user_hug_status_block']['#markup'] = $content;
    $build['#cache']['max-age'] = 0;

    return $build;
  }

}
