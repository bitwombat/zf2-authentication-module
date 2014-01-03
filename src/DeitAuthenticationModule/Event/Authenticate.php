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
	 * The authentication feedback message
	 * @var     string
	 */
	private $message;

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

	/**
	 * Gets the feedback message
	 * @return  string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets the authentication result
	 * @param   string  $message
	 * @return  $this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}

}