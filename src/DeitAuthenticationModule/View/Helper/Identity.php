<?php

namespace DeitAuthenticationModule\View\Helper;
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
	 * The fetched entity
	 * @var     object|null
	 */
	private $entity;

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

	/**
	 * Fetches the entity from the database
	 * @return  object|null
	 */
	public function __invoke() {

		//check whether the entity has alrady been fetched
		if (!is_null($this->entity)) {
			return $this->entity;
		}

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

		if (is_null($callback)) {
			$this->entity = $identity;
		} else {
			$this->entity = call_user_func_array($callback, array($identity, $sm));
		}

		return $this->entity;
	}

}