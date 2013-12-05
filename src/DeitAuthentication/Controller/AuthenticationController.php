<?php

namespace DeitAuthentication\Controller;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Authentication controller
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthenticationController extends AbstractActionController {

	/**
	 * Fired when a user has successfully logged in
	 * @param   Result $result
	 */
	const EVENT_LOGIN_SUCCESS   = 'log-in::success';

	/**
	 * Fired when a user has failed to log in
	 * @param   Result $result
	 */
	const EVENT_LOGIN_FAILURE   = 'log-in::failure';

	/**
	 * Fired when a user successfully logs out
	 * @param   mixed $identity
	 */
	const EVENT_LOGOUT          = 'log-out';

	/**
	 * Gets the authentication options
	 * @return  \DeitAuthentication\Options\Options
	 */
	public function getAuthenticationOptions() {
		return $this->getServiceLocator()->get('deit_authentication_options');
	}

	/**
	 * Gets the authentication event manager
	 * @return  \Zend\EventManager\EventManager
	 */
	public function getAuthenticationEvents() {
		return $this->getServiceLocator()->get('deit_authentication_events');
	}

	/**
	 * Gets the authentication form
	 * @return  \Zend\Form\Form
	 */
	public function getAuthenticationForm() {
		return $this->getServiceLocator('FormElementManager')->get('deit_authentication_form');
	}

	/**
	 * Gets the authentication service
	 * @return  \Zend\Authentication\AuthenticationService
	 */
	public function getAuthenticationService() {
		return $this->getServiceLocator()->get('deit_authentication_service');
	}

	/**
	 * Redirects the user to the home URL
	 * @return  \Zend\Http\Response
	 */
	public function redirectToHomeUrl() {
		return $this->redirect()->toRoute('home');
	}

	/**
	 * Redirects the user to the log-in URL
	 * @return  \Zend\Http\Response
	 */
	public function redirectToLogInUrl() {
		return $this->redirect()->toRoute('log-in');
	}

	/**
	 * Redirects the user to the return URL
	 * @return  \Zend\Http\Response
	 */
	public function redirectToReturnUrl() {

		//check for a return URL
		$returnUrl = $this->params()->fromQuery('return');

		if ($returnUrl) {

			//check the URL isn't going off to another site
			if ($returnUrl[0] == '/') {
				return $this->redirect()->toUrl($returnUrl);
			}

		}

		return $this->redirect()->toRoute('home'); //TODO: Use a preference
	}

	/**
	 * Log-in action
	 */
	public function logInAction() {

		$request    = $this->getRequest();
		$form       = $this->getAuthenticationForm();
		$service    = $this->getAuthenticationService();

		//redirect the user straight to the return URL if the user is logged in
		if ($service->hasIdentity()) {
			return $this->redirectToReturnUrl();
		}

		//check if the user has submitted the form
		if ($form->isSubmitted($request)) {

			//decide which method to use and bind the submitted data to the form
			if (strtolower($form->getAttribute('method')) == 'get') {
				$form->setData($request->getQuery());
			} else {
				$form->setData($request->getPost());
			}

			//check if the form is valid
			if ($form->isValid()) {

				//map the form data to the auth adapter

				$data       = $form->getData();
				$adapter    = $service->getAdapter();
				$callback   = $this->getAuthenticationOptions()->getMapLoginDataToAdapterCallback();

				if (is_callable($callback)) {

					//delegate mapping to the user
					call_user_func($callback, $data, $adapter);

				} else if ($adapter instanceof ValidatableAdapterInterface) {

					//map specific fields
					$adapter->setIdentity($form->get('identity')->getValue());
					$adapter->setCredential($form->get('credential')->getValue());

				} else {
					throw new \RuntimeException('Not sure how to map data from the log-in form to the authentication adapter.');
				}


				//log the user in
				$result = $service->authenticate();

				//check the result is valid
				if ($result->isValid()) {

					//trigger the log-in event
					$this->getAuthenticationEvents()->trigger(
						self::EVENT_LOGIN_SUCCESS,
						null,
						array('result' => $result)
					);

					//redirect the user to the return URL
					return $this->redirectToReturnUrl();

				} else {

					//trigger the login event
					$this->getAuthenticationEvents()->trigger(
						self::EVENT_LOGIN_SUCCESS,
						null,
						array('result' => $result)
					);

					//let the user know what went wrong
					//$error = 'An invalid username or password was supplied'

				}

			}

		}

		//create the view model
		$vm = new ViewModel();
		$vm
			->setTemplate('log-in')
			->setVariable('form', $form)
		;

		return $vm;
	}

	/**
	 * Log-out action
	 */
	public function logOutAction() {

		//get the auth service
		$service = $this->getAuthenticationService();

		//redirect the user straight to the log-in URL if the user isn't logged in
		if (!$service->hasIdentity()) {
			return $this->redirectToLogInUrl();
		}

		//get the auth identity
		$identity = $service->getIdentity();

		//log the user out
		$service->clearIdentity();

		//trigger the log-out event
		$this->getAuthenticationEvents()->trigger(
			self::EVENT_LOGOUT,
			null,
			array('identity' => $identity)
		);

		//redirect the user to the log-in URL
		return $this->redirectToLogInUrl();

	}

}
