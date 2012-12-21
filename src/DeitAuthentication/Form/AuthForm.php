<?php

namespace DeitAuthentication\Form;
use \Zend\Form\Form;

/**
 * Authentication form
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthForm extends Form {

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

}
