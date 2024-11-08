<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BusinessController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 
// Auth api
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

// business api
Route::get('allBusiness', [BusinessController::class, 'allBusiness'])->middleware('auth:api');
Route::post('createBusiness', [BusinessController::class, 'createBusiness'])->middleware('auth:api');
Route::post('updateBusiness', [BusinessController::class, 'updateBusiness'])->middleware('auth:api');

//Product api

Route::get('allProduct', [ProductController::class, 'allProduct'])->middleware('auth:api');
Route::get('showProduct', [ProductController::class, 'showProduct'])->middleware('auth:api');
Route::post('createProduct', [ProductController::class, 'createProduct'])->middleware('auth:api');
Route::post('updateProduct', [ProductController::class, 'updateProduct'])->middleware('auth:api');

//Contact api 
Route::get('allContact', [ContactController::class, 'allContact'])->middleware('auth:api');
Route::post('storeContacts', [ContactController::class, 'storeContacts'])->middleware('auth:api');