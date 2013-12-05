<?php

namespace DeitAuthentication\Options;

/**
 * Options
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Options {

	/**
	 * A callback used to map the data from the log-in form to the authentication adapter
	 * @param   string[string]                                  $data       The data provided by the user at the log-in form
	 * @param   \Zend\Authentication\Adapter\AdapterInterface   $adapter    The authentication data
	 * @var     callable
	 */
	private $mapLoginDataToAdapterCallback;

	/**
	 * A callback used to retrieve an entity object from the raw identity data provided by the authentication adapter
	 * @param   mixed                                           $identity       The raw identity data provided by the authentication adapter
	 * @param   \Zend\ServiceManager\ServiceLocatorInterface    $sm             The service manager used to fetch necessary services
	 * @var     callable
	 */
	private $fetchEntityFromIdentityCallback;

	public function getMapLoginDataToAdapterCallback() {
		return $this->mapLoginDataToAdapterCallback;
	}

	public function setMapLoginDataToAdapterCallback($callback) {
		$this->mapLoginDataToAdapterCallback = $callback;
		return $this;
	}

	public function getFetchEntityFromIdentityCallback() {
		return $this->fetchEntityFromIdentityCallback;
	}

	public function setFetchEntityFromIdentityCallback($callback) {
		$this->fetchEntityFromIdentityCallback = $callback;
		return $this;
	}

}
 