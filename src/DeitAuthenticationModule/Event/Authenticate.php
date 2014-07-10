<?php

namespace DeitAuthenticationModule\Event;

/**
 * Authentication event
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Authenticate extends \Zend\EventManager\Event {

	/**
	 * Fired when a user tries to log in
	 * @param   Result $result
	 */
	const EVENT_LOGIN   = 'log-in';

	/**
	 * Fired when a user successfully logs out
	 * @param   mixed $identity
	 */
	const EVENT_LOGOUT  = 'log-out';

	/**
	 * The authentication result
	 * @var     \Zend\Authentication\Result
	 */
	private $result;

	/**
	 * Gets the authentication result
	 * @return  \Zend\Authentication\Result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Sets the authentication result
	 * @param   \Zend\Authentication\Result $result
	 * @return  $this
	 */
	public function setResult(\Zend\Authentication\Result $result) {
		$this->result = $result;
		return $this;
	}

}