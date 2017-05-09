<?php

namespace Drupal\d8_demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherConfigForm extends ConfigFormBase {

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['d8_demo.weather_config'];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'weather_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $weather_config = $this->config('d8_demo.weather_config');

    $form['appid'] = [
      '#type' => 'textfield',
      '#title' => 'App Id',
      '#description' => 'App id obtained from https://home.openweathermap.org/api_keys',
      '#default_value' => $weather_config->get('appid')
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('d8_demo.weather_config')
      ->set('appid', $form_state->getValue('appid'))
      ->save();
    parent::submitForm($form, $form_state); // TODO: Change the autogenerated stub
  }
}