<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Api\New\AuthController;

Route::post('/dashboard/paymentStatus', 'Package\PackageController@paymentStatus')->name('PaymentStatus');

//auth


Route::group(['namespace' => 'WebServices'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('social-login', 'AuthController@socialLogin');
        Route::post('forgot-password', 'AuthController@forgotPassword');


    });

    Route::group(['middleware' => 'auth:api', 'namespace' => 'Auth'], function () {
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('logout', 'AuthController@logout');
        Route::get('/email/resend', 'VerificationController@resend')->name('api.verification.resend');

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

    Route::get('cities', 'DataController@cities');
    Route::get('city-locations/{city}', 'DataController@locations');
    Route::get('all-users', [\App\Http\Controllers\Dashboard\UserController::class, 'getAllUsers']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/users', function () {
    return response()->json([
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
    ]);
});
Route::post('/users', function (Request $request) {
    // Normally you would save to database, but we'll just return back
    return response()->json([
        'message' => 'User created successfully!',
        'user' => $request->only(['name', 'email']),
    ]);
});
Route::put('/users/{id}', function (Request $request, $id) {
    return response()->json([
//        'message' => "User $id updated successfully!",
        'user' => ['id' => $id, 'name' => $request->name, 'email' => $request->email],
    ]);
});
Route::delete('/users/{id}', function ($id) {
    return response()->json([
//        'message' => "User $id deleted successfully!",
    ]);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
