<?php

namespace Drupal\wunderhugs\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Hug edit forms.
 *
 * @ingroup wunderhugs
 */
class HugForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\wunderhugs\Entity\Hug */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;
    // Make hugs unpublished by default.
    $form['status']['widget']['value']['#default_value'] = FALSE;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Hug.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Hug.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.hug.canonical', ['hug' => $entity->id()]);
  }

}
