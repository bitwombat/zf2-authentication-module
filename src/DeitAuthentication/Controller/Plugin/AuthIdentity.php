<?php

namespace DeitAuthentication\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Auth identity controller plugin
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthIdentity extends AbstractPlugin {

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
	public function setAuthService(\Zend\Authentication\AuthenticationService $service) {
		$this->authService = $service;
		return $this;
	}

}
