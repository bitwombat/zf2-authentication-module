<?php

return array(

	'service_manager' => array(
		'factories' => array(

			'Zend\Authentication\AuthenticationService' => function($sm) {
				$authService = new \Zend\Authentication\AuthenticationService();
				$authService->setAdapter($sm->get('AuthAdapter'));
				return $authService;
			},

		),
	),

	'router' => array(
		'routes' => array(

			'authenticate' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-in',
					'defaults' => array(
						'controller' => 'DeitAuthentication\Controller\Auth',
						'action'     => 'authenticate',
					),
				),
			),

			'unauthenticate' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-out',
					'defaults' => array(
						'controller' => 'DeitAuthentication\Controller\Auth',
						'action'     => 'unauthenticate',
					),
				),
			),

		),
	),

	'controllers' => array(
		'invokables' => array(
			'DeitAuthentication\Controller\Auth' => 'DeitAuthentication\Controller\AuthController'
		),
	),

	'view_manager' => array(
		'template_map' => array(
			'deit-authentication/auth/authenticate' => __DIR__ . '/../view/deit-authentication/auth/authenticate.phtml',
		),
	),

);
