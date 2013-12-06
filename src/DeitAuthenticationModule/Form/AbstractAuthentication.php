<?php

namespace DeitAuthenticationModule\Form;
use Zend\Form\Form;
use Zend\Http\Request;

/**
 * Authentication form
 * @author James Newell <james@digitaledgeit.com.au>
 */
abstract class AbstractAuthentication extends Form implements AuthenticationInterface {

	/**
	 * @inheritdoc
	 */
	public function isSubmitted(Request $request) {
		return $request->isPost();
	}

}
