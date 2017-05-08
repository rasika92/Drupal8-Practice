<?php

namespace Drupal\my_d8_demo;

use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactory;

class WeatherCheck {
	private $config_factory;
	private $guzzle_client;
	public function __construct(ConfigFactory $config_factory, Client $guzzle_client) {
		$this->config_factory = $config_factory;
		$this->guzzle_client = $guzzle_client;
	}
	public function pullData() {
		$app_id = $this->config_factory->get ( 'my_d8_demo.weather_config' )->get ( 'appid' );
		$response = $this->guzzle_client->request ( 'GET', 'http://d8.dev/d8-demo/weather-api' );
		return json::decode ( $response->getBody ()->getContents () );

		/*
		 * $result = $this->guzzle_client->get ( 'http://api.openweathermap.org/data/2.5/weather', [
		 * 'query' => [
		 * 'q' => 'London,uk', // $city_name,
		 * 'appid' => '980dc887466a3fb3f8af598bf9e8584f'
		 * ]
		 * ] );// $app_id
		 * return $result->getBody ()->getContent ();
		 */
	}
}