<?php

namespace Drupal\my_d8_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\my_d8_demo\WeatherCheck;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 * @author training
 *
 *         @Block (
 *         id = "weather_block",
 *         admin_label = "Weather Block"
 *         )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
	public function __construct($configuration, $plugin_id, $plugin_definition, WeatherCheck $weatherCheck) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->weatherCheck = $weatherCheck;
	}
	public function build() {
		// Build function will render block content.
		$weather_data = $this->weatherCheck->pullData ( $this->configuration ['city_name'] );
		return array (
				'#theme' => 'weather_widget',
				'#weather_data' => $weather_data,
				'#attached' => [
						'library' => [
								'my_d8_demo/weather-widget'
						] // modulename/libraryname.

				]
		);
	}
	public function blockForm($form, FormStateInterface $form_state) {
		$form ['city_name'] = [
				'#type' => 'textfield',
				'#title' => 'City Name',
				'#default_value' => $this->configuration ['city_name']
		];
		return $form;
	}
	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration ['city_name'] = $form_state->getValue ( 'city_name' );
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'my_d8_demo.weather_check' ) );
	}
}
