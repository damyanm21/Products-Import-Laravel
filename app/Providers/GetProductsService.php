<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Constants\Constants;
use Illuminate\Support\Facades\Http;

class GetProductsService
{
    public function getProducts($sku, $name){
		$filtergroups = [["filters"=>[["field"=>"sku", "value"=>implode(',',$sku), "condition_type"=>"in"],["field"=>"name", "value"=>implode(',',$name), "condition_type"=>"in"]]]]; //Checks if there are existing sku and name in the db
    	$url = env('MAGENTO_URL').'rest/all/V1/products';
    	$request = Http::withHeaders(['Authorization' => 'Bearer ' . Constants::getToken()])->
		get($url, ["searchCriteria"=>["pageSize"=>10, "currentPage"=>1, "filterGroups"=>$filtergroups]]); //Checks the token and then gets products by search criteria.

	    $response = json_decode($request->body(), true);

		$result = [];
		foreach($response['items'] as $skus){
			$result[] = $skus['sku'];
		}
		return $result;
	}
}