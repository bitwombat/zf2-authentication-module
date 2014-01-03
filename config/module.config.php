<?php

return array(

	'router' => array(
		'routes' => array(

			'log-in' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-in',
					'defaults' => array(
						'controller' => 'DeitAuthenticationModule\Controller\Authentication',
						'action'     => 'log-in',
					),
				),
			),

			'log-out' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-out',
					'defaults' => array(
						'controller' => 'DeitAuthenticationModule\Controller\Authentication',
						'action'     => 'log-out',
					),
				),
			),

		),
	),

	'service_manager' => array(

		'aliases' => array(
			'Zend\Authentication\AuthenticationService'     => 'deit_authentication_service',
			'Zend\Authentication\Storage\StorageInterface'  => 'deit_authentication_storage',
			'Zend\Authentication\Adapter\AdapterInterface'  => 'deit_authentication_adapter',
		),

		'factories' => array(

			/**
			 * The module options
			 */
			'deit_authentication_options' => function($sm) {

				$config     = $sm->get('Config');
				$options    = new DeitAuthenticationModule\Options\Options();

				if (isset($config['deit_authentication'])) {

					$config = $config['deit_authentication'];

					if (isset($config['map_auth_data_to_adapter_callback'])) {
						$options->setMapAuthDataToAdapterCallback(
							$config['map_auth_data_to_adapter_callback']
						);
					}

					if (isset($config['fetch_entity_from_identity_callback'])) {
						$options->setFetchEntityFromIdentityCallback(
							$config['fetch_entity_from_identity_callback']
						);
					}

				}

				return $options;
			},

			'deit_authentication_events' => function($sm) {
				return new \Zend\EventManager\EventManager();
			},

			'deit_authentication_form' => function($sm) {
				$form = new \DeitAuthenticationModule\Form\Authentication();
				return $form;
			},

			'deit_authentication_service' => function($sm) {
				$service = new \Zend\Authentication\AuthenticationService();
				$service
					->setStorage($sm->get('deit_authentication_storage'))
					->setAdapter($sm->get('deit_authentication_adapter'))     //user needs to specify this
				;
				return $service;
			},

			'deit_authentication_storage' => function($sm) {
				$storage = new \Zend\Authentication\Storage\Session();
				return $storage;
			},

		),

	),

	'controllers' => array(
		'invokables' => array(
			'DeitAuthenticationModule\Controller\Authentication' => 'DeitAuthenticationModule\Controller\AuthenticationController'
		),
	),

	'controller_plugins' => array(
		'factories' => array(
			'identity' => function($sm) {
				$sm = $sm->getServiceLocator();
				$plugin = new \DeitAuthenticationModule\Controller\Plugin\Identity();
				$plugin->setAuthenticationService($sm->get('deit_authentication_service'));
				return $plugin;
			},
		),
	),

	'view_helpers' => array(
		'factories' => array(
			'identity' => function($sm) {
				$sm = $sm->getServiceLocator();
				$plugin = new \DeitAuthenticationModule\View\Helper\Identity();
				$plugin->setAuthenticationService($sm->get('deit_authentication_service'));
				return $plugin;
			},
		),
	),

	'view_manager' => array(
		'template_map' => array(
			'deit-authentication-module/log-in' => __DIR__.'/../view/deit-authentication-module/log-in.phtml',
		),
	),

);
