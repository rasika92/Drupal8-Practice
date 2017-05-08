<?php

namespace Drupal\my_d8_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController.
 *
 * @package Drupal\d8_demo\Controller
 */
class DefaultController extends ControllerBase {

	/**
	 * Fetchweatherdata.
	 *
	 * @return string Return Hello string.
	 */
	public function fetchWeatherData() {
		return new JsonResponse ( [
				'temp_min' => '20',
				'temp_max' => '20',
				'pressure' => '10'
		] );
	}
}
