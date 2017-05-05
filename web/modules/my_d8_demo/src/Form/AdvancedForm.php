<?php

namespace Drupal\my_d8_demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\my_d8_demo\DbWrapper;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdvancedForm extends FormBase {
	private $dbWrapper;
	public function __construct(DbWrapper $dbWrapper) {
		$this->dbWrapper = $dbWrapper;
	}
	/**
	 * Returns a unique string identifying the form.
	 *
	 * @return string The unique string identifying the form.
	 */
	public function getFormId() {
		return 'advanced_form';
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
		$result = $this->dbWrapper->getData ();
		$form ['fname'] = array (
				'#type' => 'textfield',
				'#title' => t ( 'Enter your first name' ),
				'#default_value' => $result ['fname']
		);
		$form ['lname'] = array (
				'#type' => 'textfield',
				'#title' => t ( 'Enter your last name' ),
				'#default_value' => $result ['lname']
		);
		$form ['submit'] = array (
				'#type' => 'submit',
				'#value' => t ( 'Submit' )
		);
		return $form;
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
		$fname = $form_state->getValue ( 'fname' );
		if (strlen ( $fname ) < 5) {
			$form_state->setErrorByName ( 'fname', 'First name should contain atleast 5 charcters' );
		}
		$lname = $form_state->getValue ( 'lname' );
		if (strlen ( $lname ) < 5) {
			$form_state->setErrorByName ( 'lname', 'Last name should contain atleast 5 charcters' );
		}
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
		$fname = $form_state->getValue ( 'fname' );
		$lname = $form_state->getValue ( 'lname' );
		$this->dbWrapper->setData ( $fname, $lname );
		drupal_set_message ( 'Submission Successfull' );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'my_d8_demo.dbwrapper' ) );
	}
}