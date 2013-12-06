<?php

namespace DeitAuthenticationModule\Form;
use Zend\Form\FormInterface;
use Zend\Http\Request;

/**
 * Authentication form
 * @author James Newell <james@digitaledgeit.com.au>
 */
interface AuthenticationInterface extends FormInterface {

	/**
	 * Gets whether the form has been submitted
	 * @param   Request $request
	 * @return  bool
	 */
	public function isSubmitted(Request $request);

}
