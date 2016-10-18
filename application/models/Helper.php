<?php 
class Helper {
	public static function getResponseFromServer($url , $postFields) {
		$logger = Zend_Registry::get("logger");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
        $result = curl_exec($ch);
        $logger->info("Error in calling API = ".var_export(curl_error($ch),true));
        curl_close($ch);
        $result = json_decode($result);
        
        return $result;
	}
}
?>