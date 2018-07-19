<?php

namespace Drupal\wunderhugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'UserHugStatusBlock' block.
 *
 * @Block(
 *  id = "user_hug_status_block",
 *  admin_label = @Translation("User hug status block"),
 * )
 */
class UserHugStatusBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    // Show 'add hug' link.
    $link = Link::fromTextAndUrl(t('Add hug'), Url::fromRoute('entity.hug.add_form'))->toString();
    $content = '<p>' . $link . '</p>';

    // Fetch information about this user's current hug window.
    $user = \Drupal::currentUser();
    $hug_window = checkHugWindow(time());
    $hug_count = fetchHugNo($user->id(), $hug_window['start'], $hug_window['end']);
    $content .= \Drupal::translation()->formatPlural($hug_count, '<p>You have sent 1 hug in this window.</p>', '<p>You have sent @count hugs in this window.</p>');
    $content .= '<p>' . date('d M', $hug_window['start']) . ' to ' . date('d M', $hug_window['end']) . '</p>';
    $content .= '<p>Total hugs this window: ' . fetchHugNo(NULL, $hug_window['start'], $hug_window['end']) . '</p>';

    // Fetch information about the previous window.
    $config = \Drupal::config('wunderhugs.adminsettings');
    $window_range = $config->get('hug_window');
    if ($window_range == 'Weekly') {
      $prev_window_start = $hug_window['start'] - 604800;
      $prev_window_end = $hug_window['start'] - 1;
    }
    else if ($window_range == 'Monthly') {
      $last_month_start = date('m-Y', strtotime('last month'));
      $prev_window_start = strtotime('01-' . $last_month_start . ' 00:00:00');
      $last_month_end = date('t-m-Y', $prev_month_start);
      $prev_window_end = strtotime($last_month_end . ' 23:59:59');
    }
    $content .= '<p>Prev window start: ' . date('d-m-Y', $prev_window_start) . '</p>';
    $content .= '<p>Prev window end: ' . date('d-m-Y', $prev_window_end) . '</p>';
    $content .= '<p>Total hugs previous window: ' . fetchHugNo(NULL, $prev_window_start, $prev_window_end) . '</p>';

    // Fetch information about all hugs.
    $content .= '<p>Total hugs: ' . fetchHugNo() . '</p>';

    $build['user_hug_status_block']['#markup'] = $content;
    $build['#cache']['max-age'] = 0;

    return $build;
  }

}
