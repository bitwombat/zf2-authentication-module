<?php

namespace DeitAuthentication\View\Helper;

use \Zend\View\Helper\AbstractHelper;

/**
 * Auth identity helper
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthIdentity extends AbstractHelper{

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
