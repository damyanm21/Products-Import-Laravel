<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Providers\ProductsService;
use App\Providers\GetProductsService;

class MagentoController extends Controller
{
    public function importMagentoProducts()
    {
        //Takes all the products with the same importid (imported set) and gives us all the products, which are not imported yet (with imported status different of 1).
        $products = Product::where('importid',request()->input('imported'))->where('imported' , '<>', 1)->get(); 

        $importService = new ProductsService();
        $getProductService = new GetProductsService();

        //USE ProductsService
        $existingSkus = $getProductService->getProducts(
            $products->pluck('name')->toArray(), 
            $products->pluck('name')->toArray()
        );

        $data = [];
        $errors = [];

        foreach ($products as $product) {
            
            $data[]=[
                'sku' => $product['name'],
                'name' => $product['name']
            ];       
        }
        
        $status = $importService->importProductsV2(
            $data
        );

        $products = $products->keyBy('name'); //gets collection of products by getting product and setting all laravel db properties to his name
        $items = json_decode($status['a'], true);
        $items = collect($items)->keyBy('sku');

        $created=0;
        $failed=0;

        foreach($products as $item){ //json_decode turns $status['a'] from string to array
            if(isset($items[$item['name']])){
            $item->imported=-1;
            $failed++;
            }
            else{
            $item->imported=1;
            $created++;
            }
            $item->save();
        }
    
        $products = Product::all();
        return view('home', compact('status', 'products', 'created', 'failed'));
    }
}
