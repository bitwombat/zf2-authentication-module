<?php

namespace DeitAuthentication\Form;
use Zend\Form\Form;
use Zend\Http\Request;

/**
 * Auth form
 * @author James Newell <james@digitaledgeit.com.au>
 */
class LogIn extends Form {

	/**
	 * Constructs the form
	 */
	public function __construct() {
		parent::__construct('authenticate');
		
		$this->setAttribute('method', 'post');

		$this->add(array(
			'name' => 'identity',
			'attributes' => array(
				'type'  => 'text',
				'placeholder' => 'Username',
				'required' => 'required',
				'autofocus' => 'autofocus',
			),
			'options' => array(
				'label' => 'Username',
			),
			'filters' => array(
			),
			'validators' => array(
				'NotEmpty',
			),
		));

		$this->add(array(
			'name' => 'credential',
			'attributes' => array(
				'type'  => 'password',
				'placeholder' => 'Password',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Password',
			),
			'filters' => array(
			),
			'validators' => array(
				'NotEmpty',
			),
		));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Log-in',
				'id' => 'submitbutton',
			),
		));
		
	}

	/**
	 * Gets whether the form has been submitted
	 * @param   Request $request
	 * @return  bool
	 */
	public function isSubmitted(Request $request) {
		return $request->isPost();
	}

}
