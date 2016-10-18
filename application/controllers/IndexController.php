<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $params = $this->_request->getParams();
        $logger = Zend_Registry::get("logger");
        $this->view->emailId = NULL;
        $this->view->errorMsg = NULL;

        $logger->info("Params after login = ".var_export($params,true));
        if(isset($params)) {
	        if(isset($params['email_id'])) {
	        	$this->view->emailId = $params['email_id'];
	        }
	        if(isset($params["error_message"])) {
	        	$this->view->errorMsg = $params["error_message"];
	        }
	    }

    }


}

