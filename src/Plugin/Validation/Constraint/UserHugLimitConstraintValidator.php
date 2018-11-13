<?php

namespace Drupal\wunderhugs\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the UserHugLimit constraint.
 */
class UserHugLimitConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($entity, Constraint $constraint) {
    if (isset($entity)) {
      // Check which window this applies to.
      $window_dates = wunderhugs_check_hug_window($entity->get('created')->value);
      // Check how many hugs this user has made in this window.
      $config = \Drupal::config('wunderhugs.adminsettings');
      $hug_limit = $config->get('maximum_hugs_per_window');
      $user_hug_no = fetchHugNo($entity->getOwnerId(), $window_dates['start'], $window_dates['end']);
      // Run validation.
      if ($user_hug_no >= $hug_limit) {
        $this->context->addViolation($constraint->message, ['%value' => $hug_limit]);
      }
      else {
        // The message that will be shown if the user is under their limit.
        $user_hug_no++;
        $remaining_hugs = $hug_limit - $user_hug_no;
        $remaining_hugs_text = \Drupal::translation()->formatPlural($remaining_hugs, 'You have 1 hug left in this window.', 'You have @count hugs left in this window.');
        drupal_set_message($remaining_hugs_text, 'status');
      }
    }
  }

}
