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
        Route::post('logout', 'AuthController@logout');


    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('update-profile', 'UserProfile\UserProfileController@updateProfile');
        Route::post('favourites', 'UserProfile\UserProfileController@favourites');
    });


    Route::group(['namespace' => 'Property'], function () {
        Route::get('properties/{property}', 'PropertyController@show');

        //search
        Route::get('search', 'PropertySearchController@search');
        Route::get('generic-search', 'PropertySearchController@genericSearch');
    });


    Route::get('cities', 'DataController@cities');
    Route::get('cities/{city}', 'DataController@locations');


});
