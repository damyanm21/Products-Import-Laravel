<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MagentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route for view/blade file.
Route::get('importExportView', [ExcelController::class, 'importExportView'])->name('importExportView');
// Route for export/download tabledata to .csv, .xls or .xlsx
Route::get('exportExcel/{type}', [ExcelController::class, 'exportExcel'])->name('exportExcel');
// Route for import excel data to database.
Route::post('importExcel', [ExcelController::class, 'importExcel'])->name('importExcel');

Route::get('home', [ExcelController::class, 'index']);

Route::get('token', function () {
    return view('token');
});

Route::get('test', [HomeController::class, 'test']);

Route::post('home', [MagentoController::class, 'importMagentoProducts'])->name('importMagento');