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
      $window_dates = checkHugWindow($entity['created']);
      // Check how many hugs this user has made in this window.
      $config = \Drupal::config('wunderhugs.adminsettings');
      $hug_limit = $config->get('maximum_hugs_per_window');
      $no_of_hugs = fetchHugNo($entity['user_id'], $window_dates['start'], $window_dates['end']);
      if ($no_of_hugs >= $hug_limit) {
        $this->context->addViolation($constraint->$reached_limit, ['%value' => $hug_limit]);
      }
      else {
        $remaining_hugs = $hug_limit - $no_of_hugs;
        $this->context->addViolation($constraint->$under_limit, ['%value' => $remaining_hugs]);
      }
    }
  }

}
