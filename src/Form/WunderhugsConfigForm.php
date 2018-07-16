<?php

namespace Drupal\wunderhugs\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WunderhugsConfigForm.
 */
class WunderhugsConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'wunderhugs.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wunderhugs_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('wunderhugs.adminsettings');

    $form['hug_window'] = [
      '#type' => 'radios',
      '#title' => $this->t('Hug window'),
      '#description' => $this->t('The length of time a hug window should run for.'),
      '#options' => ['Weekly' => $this->t('Weekly'), 'Monthly' => $this->t('Monthly')],
      '#default_value' => $config->get('hug_window'),
      '#weight' => '0',
    ];
    $form['start_of_the_week'] = [
      '#type' => 'select',
      '#title' => $this->t('Start of the week'),
      '#description' => $this->t('Choose the day you want your weekly window to begin on.'),
      '#options' => ['Monday' => $this->t('Monday'), 'Tuesday' => $this->t('Tuesday'), 'Wednesday' => $this->t('Wednesday'), 'Thursday' => $this->t('Thursday'), 'Friday' => $this->t('Friday'), 'Saturday' => $this->t('Saturday'), 'Sunday' => $this->t('Sunday')],
      '#size' => 1,
      '#default_value' => $config->get('start_of_the_week'),
      '#weight' => '1',
    ];
    $form['maximum_hugs_per_window'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum hugs per window'),
      '#description' => $this->t('State the number of hugs each user can award within a window period.'),
      '#default_value' => $config->get('maximum_hugs_per_window'),
      '#weight' => '2',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    // Display result.
    /*foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }*/
    $this->config('wunderhugs.adminsettings')
      ->set('hug_window', $form_state->getValue('hug_window'))
      ->set('start_of_the_week', $form_state->getValue('start_of_the_week'))
      ->set('maximum_hugs_per_window', $form_state->getValue('maximum_hugs_per_window'))
      ->save();

  }

}
