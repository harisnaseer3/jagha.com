<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/dashboard/paymentStatus', 'Package\PackageController@paymentStatus')->name('PaymentStatus');

//auth


Route::group(['namespace' => 'WebServices'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('forgot-password', 'AuthController@forgotPassword');
        Route::post('social-login', 'AuthController@socialLogin');

});

    Route::group(['middleware' => 'auth:api', 'namespace' => 'Auth'], function () {
        //profile
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('update-profile', 'AuthController@updateProfile');
        Route::post('logout', 'AuthController@logout');
    });

    //search
    Route::get('/search', 'PropertyController@search');
});
