<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\ProductsService;
use App\Providers\GetProductsService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        $sku = request()->input('sku');
        $name = request()->input('name');
        $service = new GetProductsService();
        //$service = new ProductsService();
        $service->getProducts($sku, $name);
        return view('home');
    }
}
