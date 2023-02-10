<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Constants\Constants;
use Illuminate\Support\Facades\Http;

class ProductsService
{
    public function importProducts($sku, $name){
    	$url = env('MAGENTO_URL').'rest/all/V1/products'; //Magento URL and API
    	$importData = [
                "product" => [
                  "sku"=> $sku,
                  "name"=> $name,
                  "attribute_set_id"=> 4,
                  "price"=> 0,
                  "status"=> 0,
                  "visibility"=> 0,
                  "type_id"=> "string",
                  "weight"=> 0
                ],
                "saveOptions"=> true
    	];
    	
    	$request = Http::withHeaders(['Authorization' => 'Bearer ' . Constants::getToken()])->post($url, $importData); //Checks the token and then posts the imported data to the url.
      return $request->getStatusCode() == 200;
	    /*$response = json_decode($request->body(), true);*/
    }

    public function importProductsV2(array $products){
      $url = env('MAGENTO_URL').'rest//V1/pos/products'; //Magento URL and API
    	

    	
    	$request = Http::withHeaders(['Authorization' => 'Bearer ' . Constants::getToken()])->post($url, $products); //Checks the token and then posts the imported data to the url.
	    return $response = json_decode($request->body(), true);
    }
}