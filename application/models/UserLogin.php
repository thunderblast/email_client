<?php 
class UserLogin {
	public static function verifyLoginData($emaidId , $password) {
		$logger = Zend_Registry::get("logger");
		require_once APPLICATION_PATH. "/models/Helper.php";

		$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
		$url = $constantsConfig->api->url;
		$loginEndpoints = $constantsConfig->api->loginEndpoints;

		$url = $url . $loginEndpoints;
		$postFields = "email_id=" . $emaidId . "&password=" .$password;
		$logger->info("api Url = ".var_export($url,true));
		$result = Helper::getResponseFromServer($url , $postFields);
        
        $logger->info("response from login api : " .var_export($result,true));
        return $result;
	}

	public function checkUserAuthorisation($userId , $emailId , $authToken) {
		$logger = Zend_Registry::get("logger");
		require_once APPLICATION_PATH. "/models/Helper.php";
		if($emailId == NULL || $authToken == NULL || $emailId == "" || $authToken == "" || $userId == NULL || $userId == "") {
			return array("auth_verified" => 0 , "error_message" => "Not Authorised");
		}
		else {
			$constantsConfig = new Zend_Config_Ini(APPLICATION_PATH. '/configs/constants.ini',"server_api");
			$url = $constantsConfig->api->url;
			$authorisationEndpoints = $constantsConfig->api->authorizeEndpoints;

			$url = $url . $authorisationEndpoints;
			$postFields = array("user_id" => $userId , "email_id" => $emailId , "auth_token" => $authToken);
			$result = Helper::getResponseFromServer($url , $postFields);

			$result = (array)$result;
			$logger->info("response from authorisation api : " .var_export($result,true));
			return $result;
		}
	}
}
?>