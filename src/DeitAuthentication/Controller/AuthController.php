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
			return $this->redirect()->toRoute('home'); //TODO: use preference
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

					//check for a return URL
					$returnUrl = $this->params()->fromQuery('return');

					if ($returnUrl) {

						//check the URL isn't going off to another site
						if ($returnUrl[0] == '/') {
							return $this->redirect()->toUrl($returnUrl);
						}

					}

					//return to the default page
					return $this->redirect()->toRoute('home'); //TODO: use preference

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
