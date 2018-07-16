<?php

namespace Drupal\wunderhugs\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Hug entities.
 *
 * @ingroup wunderhugs
 */
interface HugInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Hug name.
   *
   * @return string
   *   Name of the Hug.
   */
  public function getName();

  /**
   * Sets the Hug name.
   *
   * @param string $name
   *   The Hug name.
   *
   * @return \Drupal\wunderhugs\Entity\HugInterface
   *   The called Hug entity.
   */
  public function setName($name);

  /**
   * Gets the Hug creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Hug.
   */
  public function getCreatedTime();

  /**
   * Sets the Hug creation timestamp.
   *
   * @param int $timestamp
   *   The Hug creation timestamp.
   *
   * @return \Drupal\wunderhugs\Entity\HugInterface
   *   The called Hug entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Hug published status indicator.
   *
   * Unpublished Hug are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Hug is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Hug.
   *
   * @param bool $published
   *   TRUE to set this Hug to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\wunderhugs\Entity\HugInterface
   *   The called Hug entity.
   */
  public function setPublished($published);

}
