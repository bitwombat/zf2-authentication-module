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

			'log-in' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-in',
					'defaults' => array(
						'controller' => 'DeitAuthentication\Controller\Auth',
						'action'     => 'log-in',
					),
				),
			),

			'log-out' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'    => '/log-out',
					'defaults' => array(
						'controller' => 'DeitAuthentication\Controller\Auth',
						'action'     => 'log-out',
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
			'deit-authentication/auth/log-in' => __DIR__ . '/../view/deit-authentication/auth/log-in.phtml',
		),
	),

);
