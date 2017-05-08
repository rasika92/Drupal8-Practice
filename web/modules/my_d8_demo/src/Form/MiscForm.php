<?php

namespace Drupal\my_d8_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\State;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Database\Connection;

/**
 * Class MiscForm.
 *
 * @package Drupal\my_d8_demo\Form
 */
class MiscForm extends FormBase {
	private $state;
	private $database;
	public function __construct(Connection $database, StateInterface $state) {
		$this->database = $database;
		$this->state = $state;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getFormId() {
		return 'misc_form';
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		// kint ( $this->state );
		$form ['qualifications'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Qualifications' ),
				'#options' => array (
						'UG' => $this->t ( 'UG' ),
						'PG' => $this->t ( 'PG' ),
						'other' => $this->t ( 'other' )
				)
		];

		$form ['other_qualifications'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Qualifications' ),
				'#maxlength' => 64,
				'#size' => 64,
				'#states' => [
						'visible' => [
								':input[name="qualifications"]' => [
										'value' => 'other'
								]
						]
				]
		];

		$form ['country'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Country' ),
				'#options' => array (
						'india' => $this->t ( 'India' ),
						'uk' => $this->t ( 'UK' )
				),
				'#ajax' => [
						'callback' => 'Drupal\my_d8_demo\Form\MiscForm::populateStates',
						'wrapper' => 'ajax-callback-wrapper'
				],
				'#default_value' => $this->state->get ( 'country' )
		];

		$form ['ajax-container'] = [
				'#type' => 'container',
				'#attributes' => [
						'id' => 'ajax-callback-wrapper'
				]
		];

		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];

		return $form;
	}
	public function populateStates(array &$form, FormStateInterface $form_state) {
		$country = $form_state->getValue ( 'country' );
		$states ['india'] = [
				'MH',
				'TN',
				'MP'
		];
		$states ['uk'] = [
				'London',
				'Barcelona',
				'Spain'
		];
		$form ['ajax-container'] ['state'] = [
				'#type' => 'select',
				'#title' => 'State',
				'#options' => $states [$country]
		];
		return $form ['ajax-container'];
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		parent::validateForm ( $form, $form_state );
	}

	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		// Display result.
		/*
		 * foreach ( $form_state->getValues () as $key => $value ) {
		 * $this->state->set ( $key, $value );
		 * }
		 */
		$country = $form_state->getValue ( 'country' );
		kint ( $country );
		$this->state->set ( 'country', 'uk' );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'database' ), $container->get ( 'state' ) );
	}
}
