<?php

/**
 * @file
 * Contains hug.page.inc.
 *
 * Page callback for Hug entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Hug templates.
 *
 * Default template: hug.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_hug(array &$variables) {
  // Fetch Hug Entity Object.
  $hug = $variables['elements']['#hug'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
