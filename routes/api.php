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
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('logout', 'AuthController@logout');
    });

    Route::group(['middleware' => 'auth:api', 'namespace' => 'Support'], function () {
        Route::post('support', 'SupportController@sendSupportMail');
    });

    Route::group(['middleware' => 'auth:api', 'namespace' => 'UserProfile'], function () {
        Route::post('update-profile', 'UserProfileController@updateProfile');

        Route::get('favourite', 'UserProfileController@favourites');
        Route::post('favourite', 'UserProfileController@AddFavourite');
        Route::delete('favourite/{property_id}', 'UserProfileController@RemoveFavourite');

        Route::get('my-properties', 'UserProfileController@myProperties');

        Route::post('save-search', 'UserProfileController@addUserSearch');
        Route::get('save-search', 'UserProfileController@getUserSaveSearches');
        Route::delete('save-search/{save_search}', 'UserProfileController@removeUserSearch');


    });

    Route::group(['namespace' => 'Property'], function () {
        Route::get('properties/{property}', 'PropertyController@show');

        //search
        Route::get('search', 'PropertySearchController@search');
        Route::get('generic-search', 'PropertySearchController@genericSearch');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::resource('property', 'PropertyController')->only(['store', 'edit', 'update', 'destroy']);
//            Route::post('draft-property', 'PropertyController@saveDraft');

        });


    });

    Route::get('cities', 'DataController@cities');
    Route::get('city-locations/{city}', 'DataController@locations');
});
