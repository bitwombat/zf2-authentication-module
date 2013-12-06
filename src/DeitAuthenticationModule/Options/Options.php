<?php

namespace DeitAuthenticationModule\Options;

/**
 * Options
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Options {

	/**
	 * A callback used to map the user submitted data from the authentication form to the authentication adapter
	 * @param   string[string]                                  $data       The data provided by the user at the log-in form
	 * @param   \Zend\Authentication\Adapter\AdapterInterface   $adapter    The authentication data
	 * @var     callable|null
	 */
	private $mapAuthDataToAdapterCallback;

	/**
	 * A callback used to retrieve an entity object from the raw identity data provided by the authentication adapter
	 * @param   mixed                                           $identity       The raw identity data provided by the authentication adapter
	 * @param   \Zend\ServiceManager\ServiceLocatorInterface    $sm             The service manager used to fetch necessary services
	 * @var     callable|null
	 */
	private $fetchEntityFromIdentityCallback;

	/**
	 * Gets the callback used to map the user submitted data from the authentication form to the adapter
	 * @return  callable|null
	 */
	public function getMapAuthDataToAdapterCallback() {
		return $this->mapAuthDataToAdapterCallback;
	}

	/**
	 * Sets the callback used to map the user submitted data from the authentication form to the adapter
	 * @param   callable $callback
	 * @return  $this
	 * @throws  \InvalidArgumentException
	 */
	public function setMapAuthDataToAdapterCallback($callback) {

		if (!is_callable($callback)) {
			throw new \InvalidArgumentException('Callback is not callable');
		}

		$this->mapAuthDataToAdapterCallback = $callback;
		return $this;
	}

	/**
	 * Gets the callback used to retrieve an entity object from the raw identity data provided by the authentication adapter
	 * @return  callable
	 */
	public function getFetchEntityFromIdentityCallback() {
		return $this->fetchEntityFromIdentityCallback;
	}

	/**
	 * Sets the callback used to retrieve an entity object from the raw identity data provided by the authentication adapter
	 * @param   callable $callback
	 * @return  $this
	 * @throws  \InvalidArgumentException
	 */
	public function setFetchEntityFromIdentityCallback($callback) {

		if (!is_callable($callback)) {
			throw new \InvalidArgumentException('Callback is not callable');
		}

		$this->fetchEntityFromIdentityCallback = $callback;
		return $this;
	}

}
 