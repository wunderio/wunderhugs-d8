<?php

namespace Drupal\wunderhugs\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks if the user is within their hug limit.
 *
 * @Constraint(
 *   id = "UserHugLimit",
 *   label = @Translation("Hug limit", context = "Validation"),
 * )
 */
class UserHugLimitConstraint extends Constraint {

  // The message that will be shown if the user has reached their limit.
  public $message = 'You have reached your limit of %value hugs in this window.';

}
