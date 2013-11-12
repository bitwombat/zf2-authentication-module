
= Zend Framework 2 module: DeitAuthentication =

This module is a simple reusable authentication module which provides functionality
for your users to log-in and log-out.

To hook up the module to your user base, add a service to the service manager: 
<code>
	'service_manager' => array(
		'factories' => array(
		
			'AuthAdapter' => function($sm) {

				$options = new \DoctrineModule\Options\Authentication();
				$options
					->setObjectManager('doctrine.documentmanager.odm_default')
					->setObjectRepository($sm->get('doctrine.entitymanager.orm_default')->getRepository('MyNamespace\Entity\User'))
					->setIdentityClass('MyNamespace\Entity\User')
					->setIdentityProperty('username')
					->setCredentialProperty('password')
					//->setCredentialCallable('MyNamespace\Entity\User::setPassword')
				;

				$adapter = new \DoctrineModule\Authentication\Adapter\ObjectRepository($options);
				return $adapter;
			},

		),
	),
</code>

To restrict access to your controllers to certain users, look at the DeitAuthorisation module.