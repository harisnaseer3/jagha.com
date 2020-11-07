<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'PropertyController@index')->name('home');

//ajax calls
Route::get('/locations', 'Dashboard\LocationController@cityLocations');

Route::get('/areaUnit', 'PropertyController@getAreaValue');
Route::get('/features', 'FeatureController@getFeatures');
Route::get('/resetForm', 'PropertyController@resetFrom');
Route::post('/validation', 'AgencyController@validateFrom')->name('validation');
Route::post('/subscribe', 'SubscriberController@store')->name('subscribe');
Route::post('/contactAgent', 'ContactAgentController@store')->name('contact');
Route::get('/load-more-data', 'BlogController@more_data');
Route::post('/searchWithID', 'PropertyController@searchWithID')->name('property.search.id');
Route::get('/get-featured-properties', 'Api\IndexPageController@getFeaturedProperties');
Route::get('/get-featured-partners', 'Api\IndexPageController@getFeaturedAgencies');
Route::get('/get-popular-places', 'PropertyController@getPopularPlaces')->name('property.popular-places');
Route::get('/get-main-page-blogs', 'BlogController@recentBlogsOnMainPage')->name('property.main-page-blogs');
Route::get('/get-similar-properties', 'Api\DetailPageController@getSimilarProperties');
Route::get('/get-key-partners', 'Api\IndexPageController@getKeyAgencies');
Route::post('/propertyFavorite', 'Api\DetailPageController@getPropertyFavoriteUser');


Route::post('/search-ref', 'PropertyController@userPropertySearch')->name('property.search.ref');

Route::get('featured-properties', 'PropertyController@featuredProperties')->name('featured');
Route::get('featured-partners', 'AgencyController@listingFeaturedPartners')->name('featured-partners');
Route::get('key-partners', 'AgencyController@listingKeyPartners')->name('key-partners');
//get featured or key partner on city base
Route::get('{agency}-partners/{city}', 'AgencyController@listingPartnersCitywise')->name('city.wise.partners');


//nav bar homes, plots, commercials
Route::get('/{type}_property', 'PropertyController@getPropertyListing')->name('properties.get_listing');
Route::get('/all_cities/pakistan/{type}', 'CountTableController@getCitywisePropertyCount')->name('property.city.count.listing')
    ->where([
        'type' => '(homes|plots|commercial)',
    ]);


Route::get('/{sub_type}_for_{purpose}/{city}/', 'PropertyController@searchWithArgumentsForProperty')->name('sale.property.search');
Route::get('/cities-{city}', 'PropertyController@searchInCities')->name('cities.sale.property');
Route::get('/agents-{city}', 'AgencyController@ListingCityAgencies')->name('agencies.citywise.listing');
Route::get('{type}_for_sale/{city}/{location}', 'PropertyController@searchForHousesAndPlots')->name('search.houses.plots');
Route::get('/all-cities/pakistan/{purpose}-{type}', 'CountTableController@getAllCities')->name('cities.listings')
    ->where([
        'purpose' => '(1|2)',
        'type' => '(1|2|3|4)',
    ]);

//agents
Route::get('/partners/', 'AgencyController@index')->name('agents.listing');
Route::get('partners-{city}/{slug}_{agency}', 'AgencyController@show')->name('agents.ads.listing');


//list of blogs
Route::get('/blogs/', 'BlogController@index')->name('blogs.index');
Route::get('/blogs/{slug}_{blogs}', 'BlogController@show')->name('blogs.show');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth','verified']], function () {
    Route::resource('properties', 'PropertyController')->except(['index', 'show']);
    Route::resource('images', 'ImageController')->only(['destroy']);
    Route::resource('floorPlans', 'FloorPlanController')->only(['destroy']);
    Route::resource('videos', 'VideoController')->only(['destroy']);

    Route::prefix('properties/{property}')->group(function () {
        Route::get('/favorites', 'FavoriteController@store')->name('properties.favorites.store');
        Route::get('/favorites/{user}', 'FavoriteController@destroy')->name('properties.favorites.destroy');
    });
    Route::get('listings/status/{status}/purpose/{purpose}/user/{user}/sort/{sort}/order/{order}/page/{page}', 'PropertyController@listings')
        ->name('properties.listings')
        ->where([
            'status' => '(active|edited|pending|expired|uploaded|hidden|deleted|rejected|sold|rejected_images|rejected_videos)',
            'purpose' => '(all|sale|rent|wanted|basic|silver|bronze|golden|platinum)',
            'user' => '(\d+|all)',
            'sort' => '(id|type|location|price|expiry|views|image_count)',
            'order' => '(asc|desc)',
            'page' => '\d+',
        ]);
    Route::get('agencies/status/{status}/purpose/{purpose}/user/{user}/sort/{sort}/order/{order}/page/{page}', 'AgencyController@listings')
        ->name('agencies.listings')
        ->where([
            'status' => '(verified_agencies|pending_agencies|expired_agencies|rejected_agencies|deleted_agencies)',
            'purpose' => '(all|featured|key)',
            'user' => '(\d+|all)',
            'sort' => '(id|type|location)',
            'order' => '(asc|desc)',
            'page' => '\d+',
        ]);
    Route::get('agencies/{agency}/add-users', 'AgencyUserController@addUsers')
        ->name('agencies.add-users');

    Route::post('agencies/{agency}/add-users', 'AgencyUserController@storeAgencyUsers')
        ->name('agencies.store-agency-users');

    Route::post('agencies/accept-invitation', 'AgencyUserController@acceptInvitation')
        ->name('agencies.accept_invitation');

    Route::post('agencies/reject-invitation', 'AgencyUserController@rejectInvitation')
        ->name('agencies.reject_invitation');

    Route::get('/user-dashboard', 'Dashboard\UserDashboardController@index')->name('user.dashboard');
    Route::get('/message-center', 'MessageCenter\MessageCenterController@index')->name('message.center');
    Route::get('/support', 'Support\SupportController@index')->name('aboutpakistan.support');
    Route::get('/user-logs', 'Log\UserLogController@index')->name('user.logs');

    Route::group(['prefix' => 'accounts'], function () {
        Route::resource('/users', 'Dashboard\UserController')->only(['edit', 'update']); // user is not allowed other methods
        Route::get('/logout', 'AccountController@userLogout')->name('accounts.logout');

        Route::get('/roles', 'AccountController@editRoles')->name('user_roles.edit');
        Route::match(['put', 'patch'], '/roles', 'AccountController@updateRoles')->name('user_roles.update');

        Route::get('/settings', 'AccountController@editSettings')->name('settings.edit');
        Route::match(['put', 'patch'], '/settings', 'AccountController@updateSettings')->name('settings.update');

        Route::get('/password', 'Dashboard\UserController@editPassword')->name('password.edit');
        Route::match(['put', 'patch'], '/password', 'Dashboard\UserController@updatePassword')->name('user.password.update');

        Route::resource('agencies', 'AgencyController'); // user is not allowed other methods
    });

//    ajax call to change status by the user
    Route::post('/change-status', 'PropertyController@changePropertyStatus')->name('change.property.status');
    Route::post('/agency-change-status', 'AgencyController@changeAgencyStatus')->name('change.agency.status');

//    read notification about property
    Route::post('/property-notification', 'NotificationController@ReadPropertyStatus');
    Route::post('/agency-notification', 'NotificationController@ReadAgencyStatus');


});

Route::group(['prefix' => 'properties'], function () {
    Route::get('/search', 'PropertyController@search')->name('properties.search');
    //Property detail view
    Route::get('/{slug}_{property}', 'PropertyController@show')->name('properties.show');
});


Auth::routes(['verify' => true]);
//only logged in user can view following
Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['auth','verified']], function () {
//    Route::get('/', 'DashboardController@index');
//    Route::get('/logout', 'DashboardController@logout');

    Route::group(['prefix' => 'admin', 'middleware' => 'can:manage-users'], function () {
        Route::resource('/users', 'UserController')->only(['index', 'show', 'destroy']); // admin is not allowed other methods
        Route::resource('/roles', 'RoleController');
    });

    Route::resource('/locations', 'LocationController');
    Route::resource('/cities', 'CityController');
});
// admin routes
Route::get('admin-login', 'AdminAuth\AuthController@adminLogin')->name('admin.login');
Route::post('admin-login', ['as' => 'admin-login', 'uses' => 'AdminAuth\AuthController@adminLoginPost']);
Route::post('/search-id', 'PropertyController@adminPropertySearch')->name('admin.property.search.id');
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {


    Route::get('listings/status/{status}/purpose/{purpose}/admin/{user}/sort/{sort}/order/{order}/page/{page}', 'PropertyController@listings')
        ->name('admin.properties.listings')
        ->where([
            'status' => '(active|edited|pending|expired|uploaded|hidden|deleted|rejected|sold|rejected_images|rejected_videos)',
            'purpose' => '(all|sale|rent|wanted|basic|silver|bronze|golden|platinum)',
            'admin' => '(\d+|all)',
            'sort' => '(id|type|location|price|expiry|views|image_count)',
            'order' => '(asc|desc)',
            'page' => '\d+',
        ])->middleware(['permission:Manage Property']);

    Route::get('/dashboard', 'Admin\AdminDashboardController@index')->name('admin.dashboard')->middleware(['permission:Manage Dashboard']);
    Route::get('/manage-admins', 'Admin\UserManagementController@index')->name('admin.manage-admins')->middleware(['permission:Manage Admins']);
    Route::get('/manage-users', 'Admin\UserManagementController@getUsers')->name('admin.manage-users')->middleware(['permission:Manage Users']);
    Route::get('/manage-roles-permissions', 'Admin\RoleManagementController@index')->name('admin.manage-roles-permissions')->middleware(['permission:Manage Roles and Permissions']);
    Route::get('/admin-logout', 'AdminAuth\AuthController@adminLogout')->name('accounts.admin-logout');
    Route::get('/register', 'Admin\UserManagementController@showAdminRegisterForm')->name('admin.show-register-form')->middleware(['permission:Manage Users']);
    Route::post('/registration', 'Admin\UserManagementController@registration')->name('registration.submit')->middleware(['permission:Manage Users']);
    Route::get('{admin}/edit', 'Admin\UserManagementController@editAdmin')->name('admins.edit')->middleware(['permission:Manage Users']);
    Route::patch('/{admin}', 'Admin\UserManagementController@updateAdmin')->name('admins.update')->middleware(['permission:Manage Users']);
    Route::delete('/{admin}', 'Admin\UserManagementController@adminDestroy')->name('admins.destroy')->middleware(['permission:Manage Users']);
    Route::get('properties/{property}/edit', 'PropertyController@edit')->name('admin-properties-edit')->middleware(['permission:Manage Property']);
    Route::put('properties/{property}', 'PropertyController@update')->name('admin-properties-update')->middleware(['permission:Manage Property']);
    Route::delete('properties/{property}', 'PropertyController@destroy')->name('admin-properties-destroy')->middleware(['permission:Manage Property']);

    Route::delete('images/{image}', 'ImageController@destroy')->name('admin-images-destroy');
    Route::delete('floorPlans/{floorPlan}', 'FloorPlanController@destroy')->name('admin-floorPlans-destroy');
    Route::delete('videos/{video}', 'VideoController@destroy')->name('admin-videos-destroy');

    Route::post('/search-id', 'AgencyController@adminAgencySearch')->name('admin.agency.search.id');

    Route::get('agencies/status/{status}/purpose/{purpose}/user/{user}/sort/{sort}/order/{order}/page/{page}', 'AgencyController@listings')
        ->name('admin.agencies.listings')
        ->where([
            'status' => '(verified_agencies|pending_agencies|expired_agencies|rejected_agencies|deleted_agencies)',
            'purpose' => '(all|featured|key)',
            'user' => '(\d+)',
            'sort' => '(id|type|location)',
            'order' => '(asc|desc)',
            'page' => '\d+',
        ])->middleware(['permission:Manage Agency']);
    Route::get('agencies/create', 'AgencyController@create')->name('admin-agencies-create')->middleware(['permission:Manage Agency']);
    Route::post('/agencies', 'AgencyController@store')->name('admin-agencies-store')->middleware(['permission:Manage Agency']);

    Route::get('agencies/{agency}/edit', 'AgencyController@edit')->name('admin-agencies-edit')->middleware(['permission:Manage Agency']);
    Route::put('agencies/{agency}', 'AgencyController@update')->name('admin-agencies-update')->middleware(['permission:Manage Agency']);
    Route::delete('agencies/{agency}', 'AgencyController@destroy')->name('admin-agencies-destroy')->middleware(['permission:Manage Agency']);


    Route::get('agencies/{agency}/add-users', 'AgencyUserController@addUsers')
        ->name('admin.agencies.add-users')->middleware(['permission:Manage Agency']);

    Route::post('agencies/{agency}/add-users', 'AgencyUserController@storeAgencyUsers')
        ->name('admin.agencies.store-agency-users')->middleware(['permission:Manage Agency']);

    Route::post('agencies/accept-invitation', 'AgencyUserController@acceptInvitation')
        ->name('admin.agencies.accept_invitation')->middleware(['permission:Manage Agency']);

    Route::post('agencies/reject-invitation', 'AgencyUserController@rejectInvitation')
        ->name('admin.agencies.reject_invitation')->middleware(['permission:Manage Agency']);

//    ajax-call
    Route::post('/agency-change-status', 'AgencyController@changeAgencyStatus')->name('admin.change.agency.status')->middleware(['permission:Manage Agency']);
    Route::post('/change-status', 'PropertyController@changePropertyStatus')->name('admin.change.property.status')->middleware(['permission:Manage Property']);
});

//Facebook Login
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
