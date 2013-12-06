<?php

namespace DeitAuthenticationModule;
use Zend\Mvc\MvcEvent;

/**
 * Auth module
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Module {

	/**
	 * @inheritdoc
	 */
	public function onBootstrap(MvcEvent $event) {
	}

	/**
	 * @inheritdoc
	 */
	public function getConfig() {
		return include __DIR__ . '/../../config/module.config.php';
	}

	/**
	 * @inheritdoc
	 */
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__,
				),
			),
		);
	}

}
