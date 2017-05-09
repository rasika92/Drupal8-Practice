<?php
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_id_alter().
 */
function my_d8_demo_theme_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {
	$form ['sub_slogan'] = array (
			'#type' => 'textfield',
			'#title' => t ( 'Sub Slogan' ),
			'#default_value' => theme_get_setting ( 'sub_slogan' )
	);
}