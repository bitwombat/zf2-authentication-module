<?php

namespace DeitAuthentication;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use \Zend\Permissions\Acl\Acl;
use \Zend\Permissions\Acl\GenericRole as Role;
use \Zend\Permissions\Acl\GenericResource as Resource;

class Module {

	public function onBootstrap(MvcEvent $e) {
		$app    = $e->getApplication();
		$sm     = $app->getServiceManager();
		$em     = $app->getEventManager();
	}

	public function getConfig() {
		return include __DIR__ . '/../../config/module.config.php';
	}

	public function getViewHelperConfig() {
		return array(
			'factories' => array(
				'authIdentity' => function($sm) {
					$sm = $sm->getServiceLocator();
					$helper = new View\Helper\AuthIdentity();
					$helper->setAuthService($sm->get('Zend\Authentication\AuthenticationService'));
					return $helper;
				}
			),
		);
	}

	public function getControllerPluginConfig() {
		return array(
			'factories' => array(
				'authIdentity' => function($sm) {
					$sm = $sm->getServiceLocator();
					$helper = new Controller\Plugin\AuthIdentity();
					$helper->setAuthService($sm->get('Zend\Authentication\AuthenticationService'));
					return $helper;
				}
			),
		);
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

}
