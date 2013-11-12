<?php

namespace DeitAuthentication\View\Helper;

use \Zend\View\Helper\AbstractHelper;

/**
 * Auth identity helper
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthIdentity extends AbstractHelper {

	/**
	 * Returns the auth service
	 * @return \Zend\Authentication\AuthenticationService
	 */
	public function __invoke() {
		return $this->getAuthService()->getIdentity();
	}

	/**
	 * Gets the auth service
	 * @return \Zend\Authentication\AuthenticationService
	 */
	public function getAuthService() {
		return $this->authService;
	}

	/**
	 * Sets the auth service
	 * @param \Zend\Authentication\AuthenticationService $service
	 * @return $this
	 */
	public function setAuthService($service) {
		$this->authService = $service;
		return $this;
	}

}
