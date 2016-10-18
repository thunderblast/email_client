<?php

class MailManagementController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        require_once APPLICATION_PATH . "/models/Helper.php";
    }

    public function indexAction()
    {
        // action body
    }
    public function sendMailAction() {
    	$logger = Zend_Registry::get("logger");
    	$logger->info("Inside MailManagementController sendMailAction");
    	$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->layout->disableLayout();

		$url = $constantsConfig->api->url;
		$sendMailEndpoints = $constantsConfig->api->sendMailEndpoints;
		$url = $url.$sendMailEndpoints;

    	$postParams = $this->_request->getParams();
    	$postParams = http_build_query($postParams);
    	$logger->info("Url =  ".var_export($url,true));
    	$logger->info("post params mail management : ".var_export($postParams,true));
    	$response = Helper::getResponseFromServer($url ,$postParams);
    	$logger->info("Response from send mail api = ".var_export($response,true));
    	$logger->info("Count invalid user = ".var_export(count($response->invalidRecipients),true));
    	if($response->send_status == 1 && count($response->invalidRecipients) == 0 ) {
    		echo "message successfully sent";
    	}
    	elseif($response->send_status == 0) {
    		echo "Error Ocurred while sending Message";
    	}
    	else {
    		$invalidUsers = implode(",",$response->invalidRecipients);
    		echo "Message Not sent to " . $invalidUsers;
    	}
    }

    public function deleteRecipientMailsAction() {
    	$logger = Zend_Registry::get("logger");
    	$logger->info("Inside MailManagementController deleteRecipientMailsAction");

    	$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$url = $constantsConfig->api->url;
		$deleteRecipientMailsEndpoints = $constantsConfig->api->deleteRecipientMailsEndpoints;
		$url = $url.$deleteRecipientMailsEndpoints;

		$postParams = $this->_request->getParams();
    	$postParams = http_build_query($postParams);
    	$logger->info("params : ".var_export($postParams,true));

    	$response = Helper::getResponseFromServer($url ,$postParams);

    	$logger->info("params : ".var_export($response,true));
    	echo json_encode($response);

    }

	public function deleteSentMailsAction() {
    	$logger = Zend_Registry::get("logger");
    	$logger->info("Inside MailManagementController deleteSentMailsAction");

    	$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$url = $constantsConfig->api->url;
		$deleteSentMailsEndpoints = $constantsConfig->api->deleteSentMailsEndpoints;
		$url = $url.$deleteSentMailsEndpoints;

		$postParams = $this->_request->getParams();
    	$postParams = http_build_query($postParams);
    	$logger->info("params : ".var_export($postParams,true));

    	$response = Helper::getResponseFromServer($url ,$postParams);

    	$logger->info("params : ".var_export($response,true));
    	echo json_encode($response);

    }

}

