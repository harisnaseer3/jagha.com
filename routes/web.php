<?php

use App\Mail\ContactAgentMail;
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


Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
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
            'purpose' => '(all|sale|rent|wanted|super_hot_listing|hot_listing|magazine_listing)',
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

    Route::get('/user-dashboard', 'Dashboard\UserDashboardController@index')->name('user.dashboard');
    Route::get('/message-center', 'MessageCenter\MessageCenterController@index')->name('message.center');
    Route::get('/support', 'Support\SupportController@index')->name('aboutpakistan.support');
    Route::get('/user-logs', 'Log\UserLogController@index')->name('user.logs');

    Route::group(['prefix' => 'accounts'], function () {
        Route::resource('/users', 'Dashboard\UserController')->only(['edit', 'update']); // user is not allowed other methods
        Route::get('/logout', 'AccountController@logout')->name('accounts.logout');

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
});


Route::group(['prefix' => 'properties'], function () {
    Route::get('/search', 'PropertyController@search')->name('properties.search');
    //Property detail view
    Route::get('/{slug}_{property}', 'PropertyController@show')->name('properties.show');
});


Auth::routes();
//only logged in user can view following
Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index');
    Route::get('/logout', 'DashboardController@logout');

    Route::group(['prefix' => 'admin', 'middleware' => 'can:manage-users'], function () {
        Route::resource('/users', 'UserController')->only(['index', 'show', 'destroy']); // admin is not allowed other methods
        Route::resource('/roles', 'RoleController');
    });

    Route::resource('/locations', 'LocationController');
    Route::resource('/cities', 'CityController');
});

//Facebook Login
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
