<?php

namespace DeitAuthentication\Controller\Plugin;

use \Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Auth identity plugin
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthIdentity extends AbstractPlugin {

	public function __invoke() {
		return $this->getAuthService()->getIdentity();
	}

	public function getAuthService() {
		return $this->authService;
	}

	public function setAuthService($service) {
		$this->authService = $service;
		return $this;
	}

}
