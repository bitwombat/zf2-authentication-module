<?php

namespace DeitAuthentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use \Zend\Authentication\AuthenticationService;

use DeitAuthentication\Form\LogInForm;

/**
 * Authentication controller
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthController extends AbstractActionController {

	/**
	 * Log-in action
	 */
	public function logInAction() {

		$error = '';
		$form = new LogInForm();
		$request = $this->getRequest();
		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		
		//check if the user is already logged in
		if ($authService->hasIdentity()) {
			return $this->redirect()->toRoute('app'); //TODO: use preference
		}

		//check if the user has submitted the form
		if ($request->isPost()) {

			$form->setData($request->getPost());

			if ($form->isValid()) {

				//authenticate the user
				$authService->getAdapter()
					->setIdentityValue($form->get('identity')->getValue())
					->setCredentialValue($form->get('credential')->getValue())
				;
				$authResult = $authService->authenticate();
				
				//check whether the authentication succeeded
				if ($authResult->isValid()) {
					return $this->redirect()->toRoute('app'); //TODO: use preference
				} else {
					$error = 'An invalid username or password was supplied';
				}				

			}

		}

		return array('form' => $form, 'error' => $error);
	}

	/**
	 * Log-out action
	 */
	public function logOutAction() {
		$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->clearIdentity();
		return $this->redirect()->toRoute('log-in');
	}

}
