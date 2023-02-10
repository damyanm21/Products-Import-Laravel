<?php

namespace App\Constants;

class Constants
{
    public static function getToken(){
		$tokenUrl = env('MAGENTO_URL') . 'rest/V1/integration/admin/token';
		$ch = curl_init();
		$data = array("username" => "d.dobromirov", "password" => "Trivium_98");
		$data_string = json_encode($data);

		$ch = curl_init($tokenUrl);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    		'Content-Type: application/json',
	    		'Content-Length: ' . strlen($data_string))
	    	);
		$token = curl_exec($ch);
		$token = str_replace('"','',$token);
		return $token;
	}
}