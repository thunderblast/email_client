<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    public function signInAction() {
    	require_once APPLICATION_PATH. "/models/UserLogin.php";
    	$postParams = $this->_request->getParams();
    	$emailId = $postParams['email_id'];
    	$password = $postParams['password'];
        if(is_null($emailId) || is_null($password)) {
            $this->_redirect('/');
        }
		
		$response = UserLogin::verifyLoginData($emailId ,$password);

        if($response->login_verified == 1) {
            $redirectParams = array("email_id" => $emailId , "auth_token" => $response->auth_token , "user_id" => $response->user_id , "view_option" => "inbox");
            $this->_helper->redirector('view-mail', 'user-dashboard', '', $redirectParams);
        }
        else {
            $redirectParams = array("email_id" => $emailId , "error_message" => $response->error_message);
            $this->_helper->redirector('index', 'index','', $redirectParams);
        }
    }

}