<?php

namespace DeitAuthenticationModule\Form;
use Zend\InputFilter\InputProviderInterface;

/**
 * Authentication form
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Authentication extends AbstractAuthentication implements InputProviderInterface {

	/**
	 * Constructs the form
	 */
	public function __construct() {
		parent::__construct('');

		$this->setAttribute('method', 'post');

		$this->add(array(
			'name'          => 'identity',
			'options'       => array(
				'label'         => 'Username',
			),
			'attributes'    => array(
				'type'          => 'text',
				'placeholder'   => 'Username',
				'required'      => 'required',
				'autofocus'         => 'autofocus',
			),
		));

		$this->add(array(
			'name'          => 'credential',
			'options'       => array(
				'label'         => 'Password',
			),
			'attributes'    => array(
				'type'          => 'password',
				'placeholder'   => 'Password',
				'required'      => 'required',
			),
		));

		$this->add(array(
			'name'          => 'submit',
			'attributes'    => array(
				'type'          => 'submit',
				'value'         => 'Log in',
			),
		));

	}

	/**
	 * @inheritdoc
	 */
	public function getInputSpecification() {
		return array(

			array(
				'name'          => 'identity',
				'filters'       => array(
				),
				'validators'    => array(
					'NotEmpty',
				),
			),

			array(
				'name'          => 'password',
				'filters'       => array(
				),
				'validators'    => array(
					'NotEmpty',
				),
			),

		);
	}

}
