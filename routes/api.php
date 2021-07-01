<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/dashboard/paymentStatus', 'Package\PackageController@paymentStatus')->name('PaymentStatus');

//auth
Route::post('register', 'Auth\AuthController@register');
Route::post('login', 'Auth\AuthController@login');
Route::post('forgot-password', 'Auth\AuthController@forgotPassword');


Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', 'Auth\AuthController@logout');
});
