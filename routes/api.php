<?php

use App\Http\Controllers\Api\DetailPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebServices\Property\PropertyController;
use App\Http\Controllers\Api\WebServices\Auth\AuthController;
use App\Http\Controllers\Api\IndexPageController;

Route::post('/dashboard/paymentStatus', 'Package\PackageController@paymentStatus')->name('PaymentStatus');

//auth

Route::group(['namespace' => 'WebServices'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('social-login', 'AuthController@socialLogin');
        Route::post('forgot-password', 'AuthController@forgotPassword');
        Route::get('get-all-cities', 'AuthController@getAllCities');
        Route::post('wipe-database', [IndexPageController::class, 'existingsProperty']);
    });

    Route::group(['middleware' => 'auth:api', 'namespace' => 'Auth'], function () {
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('logout', 'AuthController@logout');
        Route::get('/email/resend', 'VerificationController@resend')->name('api.verification.resend');
        Route::delete('/user/delete/{user}', 'AuthController@deleteAccount');
        Route::patch('/user/toggle-status/{id}', 'AuthController@activateOrDeactivateAccount');
        Route::get('/user/profile', 'AuthController@showProfile');


    });
    Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('api.verification.verify');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('my-properties', 'UserProfile\UserProfileController@myProperties');
        Route::post('support', 'Support\SupportController@sendSupportMail');

    });

    Route::group(['middleware' => 'auth:api', 'namespace' => 'UserProfile'], function () {
        Route::post('update-profile', 'UserProfileController@updateProfile');

        Route::get('favourite', 'UserProfileController@favourites');
        Route::post('favourite', 'UserProfileController@AddFavourite');
        Route::delete('favourite/{property_id}', 'UserProfileController@RemoveFavourite');


        Route::post('save-search', 'UserProfileController@addUserSearch');
        Route::get('save-search', 'UserProfileController@getUserSaveSearches');
        Route::delete('save-search/{save_search}', 'UserProfileController@removeUserSearch');



    });

    Route::group(['namespace' => 'Property'], function () {
        Route::get('properties/{property}', 'PropertyController@show');
        Route::get('all-properties', [PropertyController::class, 'getProperties']);
        Route::get('property-count-by-city', [PropertyController::class, 'propertyCountByCities']);
        Route::get('popular-properties', [IndexPageController::class, 'getPopularProperties']);
        Route::get('featured-properties', [IndexPageController::class, 'getFeaturedPropertiesDetails']);
        Route::get('city-properties', [DetailPageController::class, 'cityProperties']);

        //search
        Route::get('search', 'PropertySearchController@search');
        Route::get('generic-search', 'PropertySearchController@genericSearch');

        Route::group(['middleware' => ['auth:api']], function () {
            Route::resource('property', 'PropertyController')->only(['store', 'edit', 'update', 'destroy']);
            Route::get('recently-viewed', 'RecentlyViewedController@show');
            Route::post('del-property-image', 'PropertyController@deleteImage');
//            Route::post('draft-property', 'PropertyController@saveDraft');
        });
    });

    Route::group(['namespace' => 'Agency'], function () {
        Route::get('key-agencies', [IndexPageController::class, 'keyAgencies']);
        Route::get('featured-agencies', [IndexPageController::class, 'featuredAgencies']);
        Route::get('agency-properties', [DetailPageController::class, 'agencyProperties']);
    });

    Route::get('cities', 'DataController@cities');
    Route::get('city-locations/{city}', 'DataController@locations');

    Route::delete('/properties/delete-old', [IndexPageController::class, 'deleteOldProperties']);
});
