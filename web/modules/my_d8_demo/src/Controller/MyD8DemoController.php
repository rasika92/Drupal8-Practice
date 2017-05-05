<?php

namespace Drupal\my_d8_demo\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;

class MyD8DemoController {
	public function static_content() {
		return array (
				'#type' => 'markup',
				'#markup' => t ( 'My DEMO MODULE!!.' )
		);
	}
	public function dynamicContent($arg) {
		return [
				'#markup' => "Value passed = " . $arg
		];
	}
	public function entityUpcaster(NodeInterface $node) {
		return [
				'#theme' => 'item-list',
				'#items' => [
						$node->getTitle (),
						$node->get ( 'body' )->getValue ()
				]
		];
	}
	public function nodeCreatorAccess(NodeInterface $node) {
		$account = \Drupal::service ( 'current_user' );

		if ($node->getOwnerId () === $account->id ()) {
			return AccessResult::allowed ();
		} else {
			return AccessResult::forbidden ();
		}
	}
}