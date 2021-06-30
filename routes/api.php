<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/dashboard/paymentStatus', 'Package\PackageController@paymentStatus')->name('PaymentStatus');

//Route::group(['namespace' => 'Api'], function () {

    //auth
    Route::post('register', 'Auth\AuthController@register');
    Route::post('login', 'Auth\AuthController@login');

//});

