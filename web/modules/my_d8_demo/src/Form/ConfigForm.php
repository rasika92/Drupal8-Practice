<?php

namespace Drupal\my_d8_demo\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

class ConfigForm extends ConfigFormBase {

	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 */
	public function getFormId() {
		return 'custom_config_form';
	}

	/**
	 * Form constructor.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 *
	 * @return array The form structure.
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['api_key'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Weather app API key' ),
				'#default_value' => $this->config ( 'my_d8_demo.weather_config' )->get ( 'appid' )
		];
		return parent::buildForm ( $form, $form_state );
	}

	/**
	 * Form validation handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
	}

	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *        	An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *        	The current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config ( 'my_d8_demo.weather_config' )->set ( 'appid', $form_state->getValue ( 'api_key' ) )->save ();
		parent::submitForm ( $form, $form_state );
	}
	protected function getEditableConfigNames() {
		return [
				'my_d8_demo.weather_config'
		];
	}
}