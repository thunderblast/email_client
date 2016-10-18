<?php

class UserDashboardController extends Zend_Controller_Action {

    public function init() {
    	require_once APPLICATION_PATH. "/models/UserLogin.php";
        $params = $this->_request->getParams();
        $userLogin = new UserLogin();
        $authCheck = $userLogin->checkUserAuthorisation($params['user_id'] , $params['email_id'] ,$params['auth_token']);
        if($authCheck['auth_verified'] != 1) {
        	$redirectParams = array("email_id" => $authCheck['email_id'] , "error_message" => $authCheck['error_message']);
            $this->_helper->redirector('index', 'index','', $redirectParams);
        }
    }

    public function indexAction() {
        $params = $this->_request->getParams();
        $logger = Zend_Registry::get("logger");

        $logger->info("Params after login = ".var_export($params,true));
        $this->view->authToken = $params['auth_token'];
        $this->view->userId = $params['user_id'];
        $this->view->emailId = $params['email_id'];

    }

    public function viewMailAction() {
    	$params = $this->_request->getParams();
    	if(!isset($params['view_option']) || !isset($params['user_id']))
    		$errorMsg = $errorMsg + "Invalid Request";
    	else {
	    	require_once APPLICATION_PATH . "/models/Helper.php";
	    	$logger = Zend_Registry::get("logger");
	    	$logger->info("Inside UserDashboardController viewMailAction");

	    	$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
			//$this->_helper->viewRenderer->setNoRender(TRUE);

			$url = $constantsConfig->api->url;
			$viewMailEndpoints = $constantsConfig->api->viewMailEndpoints;
			$url = $url.$viewMailEndpoints;

	    	$postParams = http_build_query($params);
	    	$logger->info("Url =  ".var_export($url,true));
	    	$logger->info("post params mail management : ".var_export($postParams,true));
	    	$response = Helper::getResponseFromServer($url ,$postParams);
	    	$logger->info("Response from send mail api = ".var_export($response,true));

	    	$this->view->user_id = $params['user_id'];
	    	$this->view->email_id = $params['email_id'];
	    	$this->view->auth_token = $params['auth_token'];
	    	$this->view->view_option = $params['view_option'];
	    	$this->view->mails = $response->user_mails;
	    	$this->view->baseUrl = "dev.email.client.com/user-dashboard/view-mail/user_id/".urlencode($params['user_id'])."/email_id/".urlencode($params['email_id'])."/auth_token/".urlencode($params['auth_token'])."/view_option/";
	    }

    }


}

