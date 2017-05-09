<?php

namespace Drupal\my_d8_demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'LatestNodeTitleBlock' block.
 *
 * @Block(
 * id = "latest_node_title_block",
 * admin_label = @Translation("Latest node title block"),
 * )
 */
class LatestNodeTitleBlock extends BlockBase implements ContainerFactoryPluginInterface {

	/**
	 * Drupal\Core\Database\Driver\mysql\Connection definition.
	 *
	 * @var \Drupal\Core\Database\Driver\mysql\Connection
	 */
	protected $database;
	protected $account;
	/**
	 * Construct.
	 *
	 * @param array $configuration
	 *        	A configuration array containing information about the plugin instance.
	 * @param string $plugin_id
	 *        	The plugin_id for the plugin instance.
	 * @param string $plugin_definition
	 *        	The plugin implementation definition.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, AccountProxy $account) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->database = $database;
		$this->account = $account;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'database' ), $container->get ( 'current_user' ) );
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function build() {
		$build = [ ];
		$result = $this->fetchNodeTitle ();
		$nodetitles = $result ['title'];
		$nodetags = $result ['tags'];
		$email = $this->account->getEmail ();
		$build ['latest_node_title_block'] ['#markup'] = implode ( ', ', $nodetitles ) . ', ' . $email;
		$build ['latest_node_title_block'] ['#cache'] = [
				'tags' => $nodetags,
				'contexts' => [
						'user'
				]
		];
		return $build;
	}
	public function fetchNodeTitle() {
		$results = $this->database->select ( 'node_field_data', 'nfd' )->fields ( 'nfd', array (
				'nid',
				'title'
		) )->range ( 0, 3 )->orderBy ( 'created', 'DESC' )->execute ()->fetchAll ();
		foreach ( $results as $result ) {
			$nodetitle [] = $result->title;
			$node_tags [] = 'node:' . $result->nid;
		}
		$data = array (
				'title' => $nodetitle,
				'tags' => $node_tags
		);
		return $data;
	}
}
