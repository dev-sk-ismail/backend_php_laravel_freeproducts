<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginRegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProductController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/
 
//Front end
Route::get('/', [UserController::class, 'index']);
Route::get('order', [UserController::class, 'order']);
Route::post('order', [UserController::class, 'order']);
Route::post('searchOffer',[UserController::class, 'search_offer']);
Route::post('usingDay',[UserController::class, 'usingDay']);
Route::get('product-survey',[UserController::class, 'product_survey']);
Route::post('survey',[UserController::class, 'survey']);
Route::get('survey',[UserController::class, 'survey']);
Route::get('confirmAddress',[UserController::class, 'confirmAddress']);
Route::post('userdata',[UserController::class, 'sentUserData']);
Route::get('sendMail', [UserController::class, 'sendMail']);
Route::get('thankyou', [UserController::class, 'thankyou']);

//Login end
Route::get('admin', [LoginRegistrationController::class,'index']);
Route::post('login', [LoginRegistrationController::class, 'login']);
Route::post('register', [LoginRegistrationController::class, 'register']);
Route::get('admin/logout', [LoginRegistrationController::class, 'logout']);

//Admin end
Route::get('admin/dashboard', 'App\Http\Controllers\DashboardController@index');
Route::get('admin/leads', 'App\Http\Controllers\LeadController@index');
Route::get('admin/leads', 'App\Http\Controllers\LeadController@index');
Route::get('admin/leads/view/{id}', 'App\Http\Controllers\LeadController@view');

Route::get('admin/products', 'App\Http\Controllers\ProductController@index');
Route::get('admin/products/add', [ProductController::class, 'add']);
Route::post('admin/products/saveProduct', [ProductController::class, 'newProductCreate']);
Route::get('admin/products/view/{id}', 'App\Http\Controllers\ProductController@view');
