<?php

namespace DeitAuthentication\View\Helper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Identity helper
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Identity extends \Zend\View\Helper\Identity implements ServiceLocatorAwareInterface {

	/**
	 * The service locator
	 * @var     ServiceLocatorInterface
	 */
	private $serviceLocator;

	/**
	 * @inheritdoc
	 */
	public function getServiceLocator() {
		return $this->serviceLocator;
	}

	/**
	 * @inheritdoc
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
		return $this;
	}

	public function __invoke() {

		//get the identity
		$identity = parent::__invoke();

		//check the entity is not null
		if (is_null($identity)) {
			return null;
		}

		//fetch the identity object
		$sm         = $this->getServiceLocator()->getServiceLocator();
		$options    = $sm->get('deit_authentication_options');
		$callback   = $options->getFetchEntityFromIdentityCallback();

		if ($callback) {
			$entity = call_user_func_array($callback, array($identity, $sm));
		} else {
			$entity = $identity;
		}

		return $entity;
	}

}