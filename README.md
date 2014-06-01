
# DeitAuthenticationModule #

DeitAuthenticationModule is a pre-built authentication module for Zend Framework v2. It provides log-in and log-out functionality with a high degree of flexibility. To restrict access to routes, controller actions or other resources, also check out our DeitAuthorisationModule module.

For a full featured authentication module see [ZfcUser](https://github.com/ZF-Commons/ZfcUser).

## Installation ##
### With Composer ###
Add `"digitaledgeit/zf2-authentication-module": "master-dev"` to the `require` section of your composer.json file and then run `composer update`.

### Without Composer ###
Download the repo archive, create a new directory named `%app%/module/DeitAuthenticationModule` and extract the contents of the archive.

## Configuration ##

Configure `application.config.php` to load the module:

	'modules' => array(
		'DeitAuthenticationModule',
		'Application',
	),

Configure an authentication adapter that implements \Zend\Authentication\Adapter\AdapterInterface.

	'service_manager' => array(
		'factories' => array(
			'deit_authentication_adapter' => function($sm) {

				//create an adapter
				//for example: http://framework.zend.com/manual/2.0/en/modules/zend.authentication.adapter.dbtable.html
				//for example: https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md

			},
		),
	),


## Getting the authenticated identity ##

The module provides a controller plugin and a view helper for fetching the identity.

	$this->identity();

When adapters like `\Zend\Authentication\Adapter\DbTable` or `\DoctrineModule\Authentication\Adapter\ObjectRepository` retrieve a database entity and store it as the identity in the session, then you often run into problems with the identity data stored in the session being out-of-date after the identity has been updated in the database (e.g. if they've updated their name and you use the `identity` view helper to fetch the user's name in the layout then the updated name won't display until next time the user logs in).

To circumvent this issue you may specify a callback to fetch the entity on each page request so its always up-to-date.

	'deit_authentication' => array(
		'fetch_entity_from_identity_callback' => function($identity, \Zend\ServiceManager\ServiceLocatorInterface $sm) {

			//fetch and return your entity

			//for example: fetch a user based on the user's Facebook ID returned by the adapter
			return $em->findOneById($identity['facebook_id');

		}
	),

## Using a custom view ##

The default view is very basic and just displays the heading "Log in" and uses the form view helper to render the form. Changing the view to your own is simple. Just override the template mapping like so:

	'view_manager' => array(
		'template_map' => array(
			'deit-authentication-module/log-in' => __DIR__.'/../view/your-view-path/log-in.phtml',
		),
	),

	The view is passed two variables, a `$form` and a feedback `$message`. When an error occurs the `$message` may contain a message similar to "invalid credentials, please try again".

## Using a custom form ##

Override the `deit_authentication_form` key in the service manager to provide your own form. Forms must implement `\DeitAuthenticationModule\Form\AuthenticationInterface` or extend `\DeitAuthenticationModule\Form\AbstractAuthentication`.

	'service_manager' => array(
        'factories' => array(
            'deit_authentication_form' => function($sm) {
                return new \Application\Form\MyAuthenticationForm();
            },
        },
    },

By default the form is validated on POST but this behaviour can be overridden by implementing the `isSubmitted($request)` method.

	class MyForm extends \DeitAuthenticationModule\Form\AbstractAuthentication {
		public function isSubmitted(\Zend\Http\Request $request) {
			return $request->isGet() && $request->getQuery('identity') && $request->getQuery('credential');
		}
	}

If your form doesn't provide an identity or credential field you can specify a callback to map the user submitted data to your adapter.

	'deit_authentication' => array(
        'map_auth_data_to_adapter_callback' => function(array $data, \Zend\Authentication\Adapter\AdapterInterface $adapter) {

			//in this example the adapter has a single parameter (not identity and credential like the ones provided by Zend).
			//this will be useful for alternate log-in schemes like Facebook OAuth
            if (isset($data['code'])) {
                $adapter->setCode($data['code']);
            }

        },
	),

## Listening for events ##

The authentication controller triggers three events, `log-in::success`, `log-in::failure` and `log-out`. The module provides its own `\Zend\EventManager\EventManager` and can be retrieved from the service manager using the  `deit_authentication_events` key.

	class Module {

		public function onBootstrap(MvcEvent $event) {

			$sm = $event->getApplication()->getServiceManager();
			$em = $sm->get('deit_authentication_events');

			$em->attach('log-in', function($event /** @var \DeitAuthenticationModule\Event\Authenticate $event */) {

				if ($event->getResult()->isValid()) {
					//handle the event here
				}

			});

            $em->attach('log-out', function($event) {

				/**
				 * @var mixed $oldIdentity
				 */
				$oldIdentity = $event->getParam('identity');

                //handle the event here

            });

		}

	}
