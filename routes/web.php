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
Route::get('admin/dashboard', [DashboardController::class, 'index']);
Route::get('admin/leads', [LeadController::class, 'index']);
Route::get('admin/leads/view/{id}', [LeadController::class, 'view']);

Route::group(['prefix' => 'admin/products'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/add', [ProductController::class, 'add']);
    Route::post('/saveProduct', [ProductController::class, 'newProductCreate']);
    Route::get('/view/{id}', [ProductController::class, 'view']);
    Route::post('/update/{id}', [ProductController::class, 'update']); // Add update route
    Route::post('/delete/{id}', [ProductController::class, 'destroy']); // Add delete route
});
