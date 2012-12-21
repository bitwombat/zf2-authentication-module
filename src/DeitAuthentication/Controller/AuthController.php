<?php

namespace DeitAuthentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use \Zend\Authentication\AuthenticationService;

use DeitAuthentication\Form\AuthForm;

/**
 * Authentication controller
 * @author James Newell <james@digitaledgeit.com.au>
 */
class AuthController extends AbstractActionController {

	/**
	 * Authenticates the user
	 */
	public function authenticateAction() {

		$form = new AuthForm();
		$request = $this->getRequest();

		if ($request->isPost()) {

			$form->setData($request->getPost());

			if ($form->isValid()) {

				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				$authService->getAdapter()
					->setIdentityValue($form->get('identity')->getValue())
					->setCredentialValue($form->get('credential')->getValue())
				;
				$authResult = $authService->authenticate();

				return $this->redirect()->toRoute('home'); //TODO: use preference

			}

		}

		return array('form' => $form);
	}

	/**
	 * Unauthenticates the user
	 */
	public function unauthenticateAction() {
		$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->clearIdentity();
		return $this->redirect()->toRoute('authenticate');
	}

}
