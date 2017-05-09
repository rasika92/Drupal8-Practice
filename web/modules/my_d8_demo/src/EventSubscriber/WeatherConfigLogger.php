<?php

namespace Drupal\my_d8_demo\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\my_d8_demo\Event\WeatherConfigEvent;

class WeatherConfigLogger implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				WeatherConfigEvent::WEATHER_CONFIG_UPDATE => [
						'WeatherConfigSubmit'
				]
		];
	}
	public function WeatherConfigSubmit(WeatherConfigEvent $event) {
		$appid = $event->getAppid ();
		drupal_set_message ( "The appid $appid is set successfully" );
	}
}