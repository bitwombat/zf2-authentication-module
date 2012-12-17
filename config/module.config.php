<?php

return array(

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
