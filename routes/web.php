<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index')->name('home');

//Route::get('/user-location', 'TestController@index');


//ajax calls
Route::get('/locations', 'Dashboard\LocationController@cityLocations');
Route::get('/agency-users', 'AgencyUserController@getAgencyUsers');
Route::get('/agent-properties', 'AgencyUserController@getAgentProperties');
Route::get('/get-admin-agencies', 'PropertyAjaxCallController@allAgencies');

Route::get('/mapCall', 'PropertyAjaxCallController@mapCall');


Route::get('/user-info', 'AgencyUserController@getAgencyUserData');
Route::get('/areaUnit', 'PropertyAjaxCallController@getAreaValue');
Route::get('/features', 'FeatureController@getFeatures');
Route::get('/resetForm', 'PropertyController@resetFrom');
Route::post('/validation', 'AgencyController@validateFrom')->name('validation');
Route::post('/subscribe', 'SubscriberController@store')->name('subscribe');
Route::post('/contactAgent', 'ContactAgentController@store')->name('contact');
Route::get('/load-more-data', 'BlogController@more_data');
Route::get('/search', 'PropertySearchController@searchWithID')->name('property.search.id');
Route::get('/get-featured-properties', 'Api\IndexPageController@getFeaturedProperties');
Route::get('/get-about-pakistan-properties', 'Api\IndexPageController@getAboutPakistanProperties');
Route::get('/get-featured-partners', 'Api\IndexPageController@getFeaturedAgencies');
Route::get('/get-popular-places', 'Api\IndexPageController@getPopularPlaces')->name('property.popular-places');
Route::post('/get-main-page-blogs', 'BlogController@recentBlogsOnMainPage')->name('property.main-page-blogs');
Route::get('/get-similar-properties', 'Api\DetailPageController@getSimilarProperties');
Route::get('/get-key-partners', 'Api\IndexPageController@getKeyAgencies');
Route::post('/propertyFavorite', 'Api\DetailPageController@getPropertyFavoriteUser');
Route::post('/property-image-upload', 'TempImageController@ajaxImageUpload');
Route::post('/admin-user-count', 'Admin\AdminDashboardController@getUserCount');
Route::post('/admin-cron-job', 'CronJobController@executeTasks');
Route::get('/get-admin-logs', 'Admin\AdminDashboardController@getAdminLogs');
Route::get('/get-property-logs', 'Admin\AdminDashboardController@getPropertyLogs');
Route::get('/get-agency-logs', 'Admin\AdminDashboardController@getAgencyLogs');
Route::get('/get-visit-logs', 'Admin\AdminDashboardController@getVisitLogs');
Route::get('/get-visit-logs', 'Admin\AdminDashboardController@getVisitLogs');
Route::get('/get-package-logs', 'Admin\AdminDashboardController@getPackageLogs');
Route::get('/get-user-logs', 'Admin\UserManagementController@getUserLogs');
Route::get('/get-reg-user', 'Admin\UserManagementController@getRegisteredUser');

Route::post('/admin-hit-count', 'Admin\StatisticController@getHitStatistic');
Route::get('/get-top-pages', 'Admin\StatisticController@getTopPages');
Route::get('/get-top-browsers', 'Admin\StatisticController@getTopBrowser');
Route::get('/get-top-countries', 'Admin\StatisticController@getTopCountries');
Route::get('/get-top-visitors', 'Admin\StatisticController@getTopVisitors');
Route::get('/get-recent-visitors', 'Admin\StatisticController@getRecentVisitors');
Route::get('/get-referring-sites', 'Admin\StatisticController@getReferringSite');
Route::post('/top-platform', 'Admin\StatisticController@getTopPlatForm');

Route::post('/search-ref', 'PropertyAjaxCallController@userPropertySearch')->name('property.search.ref');
Route::post('/search-property-id', 'PropertyAjaxCallController@userPropertySearchById')->name('property.user.search.id');

Route::get('featured-properties', 'PropertyController@featuredProperties')->name('featured');
Route::get('featured-partners', 'AgencyController@listingFeaturedPartners')->name('featured-partners');
Route::get('key-partners', 'AgencyController@listingKeyPartners')->name('key-partners');
//get featured or key partner on city base
Route::get('{agency}-partners/{city}', 'AgencyController@listingPartnersCitywise')->name('city.wise.partners');


//nav bar homes, plots, commercials
Route::get('/{type}_property', 'PropertyController@getPropertyListing')->name('properties.get_listing');
Route::get('/all_cities/pakistan/{type}', 'CountTableController@getCitywisePropertyCount')->name('property.city.count.listing')
    ->where([
        'type' => '(homes|plots|commercial|Homes|Plots|Commercial)',
    ]);


Route::get('/{sub_type}_for_{purpose}/{city}/', 'PropertySearchController@searchWithArgumentsForProperty')->name('sale.property.search');
Route::get('/cities-{city}', 'PropertySearchController@searchInCities')->name('cities.sale.property');
Route::get('/agents-{city}', 'AgencyController@ListingCityAgencies')->name('agencies.citywise.listing');
Route::get('{type}_for_sale/{city}/{location}', 'PropertySearchController@searchForHousesAndPlots')->name('search.houses.plots');
Route::get('{type}_for_{purpose}/{city}/location/{location}', 'PropertySearchController@searchPropertyWithLocationName')->name('search.property.at.location');
Route::get('/all-cities/pakistan/{purpose}-{type}', 'CountTableController@getAllCities')->name('cities.listings')
    ->where([
        'purpose' => '(1|2)',
        'type' => '(1|2|3|4)',
    ]);
Route::get('/{type}-locations-for-{purpose}/{city}', 'CountTableController@getLocationsCount')->name('all.locations');

//agents
Route::get('/partners/', 'AgencyController@index')->name('agents.listing');
Route::get('partners-{city}/{slug}_{agency}', 'AgencyController@show')->name('agents.ads.listing');

//search partners
Route::get('/search/partners_results', 'AgencySearchController@searchPartner')->name('partners.name.search');


//list of blogs
Route::get('/blogs/', 'BlogController@index')->name('blogs.index');
Route::get('/blogs/{slug}_{blogs}', 'BlogController@show')->name('blogs.show');

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {

    Route::resource('properties', 'PropertyController')->except(['index', 'show']);
    Route::resource('images', 'ImageController')->only(['destroy']);
    Route::delete('image-delete', 'ImageController@form_destroy')->name('delete-image');
    Route::resource('floorPlans', 'FloorPlanController')->only(['destroy']);
    Route::resource('videos', 'VideoController')->only(['destroy']);

    Route::prefix('properties/{property}')->group(function () {
        Route::get('/favorites', 'FavoriteController@store')->name('properties.favorites.store');
        Route::get('/favorites/{user}', 'FavoriteController@destroy')->name('properties.favorites.destroy');
    });
    Route::get('listings/status/{status}/purpose/{purpose}/user/{user}/sort/{sort}/order/{order}/page/{page}', 'PropertyBackendListingController@listings')
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
    Route::delete('agencies/destroyAgencyUser', 'AgencyUserController@agencyUserDestroy')->name('agencies.destroy-user');

    Route::get('/user-dashboard', 'Dashboard\UserDashboardController@index')->name('user.dashboard');
    Route::get('/message-center/notifications', 'MessageCenter\MessageCenterController@index')->name('message-center.notifications');
    Route::get('/message-center/inbox', 'MessageCenter\MessageCenterController@inbox')->name('message-center.inbox');
    Route::get('/message-center/sent', 'MessageCenter\MessageCenterController@sent')->name('message-center.sent');
    Route::get('/support', 'Support\SupportController@index')->name('aboutpakistan.support');
    Route::get('/agencies/agency-staff', 'AgencyUserController@index')->name('agencies.staff');
    Route::get('/agencies/add-staff', 'AgencyUserController@addStaff')->name('agencies.add-staff');
    Route::post('/agencies/store-staff', 'AgencyUserController@storeStaff')->name('agencies.store-staff');
    Route::post('/sendSupportMail', 'Support\SupportController@sendSupportMail')->name('support.mail');

    Route::get('/packages', 'Package\PackageController@index')->name('package.index');
    Route::get('/packages/create', 'Package\PackageController@create')->name('package.create');
    Route::post('/packages', 'Package\PackageController@store')->name('package.store');
    Route::delete('/packages/{package}', 'Package\PackageController@destroy')->name('package.destroy');
    Route::get('/packages/{package}/add-properties', 'Package\PackageController@AddProperties')->name('package.add.properties');
    Route::post('/packages/{package}/search-property', 'Package\PackageController@AddProperties')->name('package.search.properties');
    Route::get('/packages/add-property', 'Package\PackageController@add')->name('package.property.add');
//    Route::get('/packages/{package}/edit', 'Package\PackageController@AddProperties')->name('package.property.search.id');
//    Route::resource('package', 'Package\PackageController');


    Route::get('/user-logs', 'Log\UserLogController@index')->name('user.logs');

    Route::group(['prefix' => 'accounts'], function () {
        Route::resource('/users', 'Dashboard\UserController')->only(['edit', 'update']); // user is not allowed other methods
        Route::get('/logout', 'Auth\LoginController@logout')->name('accounts.logout');;

        Route::get('/roles', 'AccountController@editRoles')->name('user_roles.edit');
        Route::match(['put', 'patch'], '/roles', 'AccountController@updateRoles')->name('user_roles.update');

        Route::get('/settings', 'AccountController@editSettings')->name('settings.edit');
        Route::match(['put', 'patch'], '/settings', 'AccountController@updateSettings')->name('settings.update');

        Route::get('/password', 'Dashboard\UserController@editPassword')->name('password.edit');
        Route::match(['put', 'patch'], '/password', 'Dashboard\UserController@updatePassword')->name('user.password.update');

        Route::resource('agencies', 'AgencyController'); // user is not allowed other methods
    });

//    ajax call to change status by the user
    Route::post('/change-status', 'PropertyAjaxCallController@changePropertyStatus')->name('change.property.status');
    Route::post('/agency-change-status', 'AgencyController@changeAgencyStatus')->name('change.agency.status');

//    read notification about property
    Route::post('/property-notification', 'NotificationController@ReadPropertyStatus');
    Route::post('/read-inbox-message', 'NotificationController@ReadInboxMessage');

});

Route::group(['prefix' => 'properties'], function () {
    Route::get('/search', 'PropertyController@search')->name('properties.search');
    //Property detail view
    Route::get('/{slug}_{property}', 'PropertyController@show')->name('properties.show');
});


Auth::routes(['verify' => true]);
Route::get('/dashboard/accounts/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('accounts.logout');


//only logged in user can view following
Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
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
Route::post('/search-id', 'PropertyAjaxCallController@adminPropertySearch')->name('admin.property.search.id');
Route::post('/search-city', 'PropertyAjaxCallController@adminPropertyCitySearch')->name('admin.property.search.city');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {


    Route::get('listings/status/{status}/purpose/{purpose}/admin/{user}/sort/{sort}/order/{order}/page/{page}', 'AdminPropertyListingController@listings')
        ->name('admin.properties.listings')
        ->where([
            'status' => '(active|edited|pending|expired|uploaded|hidden|deleted|rejected|sold|rejected_images|rejected_videos|all)',
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
    Route::post('/update-admin', 'Admin\UserManagementController@updateAdmin')->name('admins.update')->middleware(['permission:Manage Users']);
    Route::delete('/{admin}', 'Admin\UserManagementController@adminDestroy')->name('admins.destroy')->middleware(['permission:Manage Users']);
    Route::delete('/destroyUser/{user}', 'Admin\UserManagementController@userDestroy')->name('admins.destroy-user')->middleware(['permission:Manage Users']);
    Route::get('properties/{property}/edit', 'AdminPropertyController@edit')->name('admin-properties-edit')->middleware(['permission:Manage Property']);

    Route::get('properties/create', 'AdminPropertyController@create')->name('admin-properties-create')->middleware(['permission:Manage Property']);
    Route::post('properties', 'AdminPropertyController@store')->name('admin-properties-store')->middleware(['permission:Manage Property']);

    Route::put('properties/{property}', 'AdminPropertyController@update')->name('admin-properties-update')->middleware(['permission:Manage Property']);
    Route::delete('properties/{property}', 'PropertyController@destroy')->name('admin-properties-destroy')->middleware(['permission:Manage Property']);

    Route::delete('images/{image}', 'ImageController@destroy')->name('admin-images-destroy');
    Route::delete('floorPlans/{floorPlan}', 'FloorPlanController@destroy')->name('admin-floorPlans-destroy');
    Route::delete('videos/{video}', 'VideoController@destroy')->name('admin-videos-destroy');

    Route::post('/search-id', 'AgencyController@adminAgencySearch')->name('admin.agency.search.id');
    Route::post('/search-agency', 'AgencyController@adminAgencyCitySearch')->name('admin.agency.search.city');
    //agency name search form admin dashboard
    Route::post('/agency-name', 'AgencyController@AdminAgencyNameSearch')->name('admin.agency.search.name');

    Route::get('agencies/status/{status}/purpose/{purpose}/user/{user}/sort/{sort}/order/{order}/page/{page}', 'AgencyController@listings')
        ->name('admin.agencies.listings')
        ->where([
            'status' => '(verified_agencies|pending_agencies|expired_agencies|rejected_agencies|deleted_agencies|all_agencies)',
            'purpose' => '(all|featured|key)',
            'user' => '(\d+)',
            'sort' => '(id|type|location)',
            'order' => '(asc|desc)',
            'page' => '\d+',
        ])->middleware(['permission:Manage Agency']);
    Route::get('agencies/create', 'AgencyController@create')->name('admin-agencies-create')->middleware(['permission:Manage Agency']);
    Route::post('/agencies', 'AgencyController@store')->name('admin-agencies-store')->middleware(['permission:Manage Agency']);

    Route::get('agencies/{agency}/edit', 'AgencyController@edit')->name('admin-agencies-edit')->middleware(['permission:Manage Agency']);
    Route::get('agencies/{agency}/owner-edit', 'AgencyOwnerController@edit')->name('admin-agencies-owner-edit')->middleware(['permission:Manage Agency']);
    Route::put('agencies/{agency}', 'AgencyController@update')->name('admin-agencies-update')->middleware(['permission:Manage Agency']);
    Route::put('agencies/{agency}/owner-update', 'AgencyOwnerController@update')->name('admin-agencies-owner-update')->middleware(['permission:Manage Agency']);
    Route::delete('agencies/{agency}', 'AgencyController@destroy')->name('admin-agencies-destroy')->middleware(['permission:Manage Agency']);


    Route::get('agencies/{agency}/add-users', 'AgencyUserController@addUsers')
        ->name('admin.agencies.add-users')->middleware(['permission:Manage Agency']);

    Route::post('agencies/{agency}/add-users', 'AgencyUserController@storeAgencyUsers')
        ->name('admin.agencies.store-agency-users')->middleware(['permission:Manage Agency']);

    Route::post('agencies/accept-invitation', 'AgencyUserController@acceptInvitation')
        ->name('admin.agencies.accept_invitation')->middleware(['permission:Manage Agency']);

    Route::post('agencies/reject-invitation', 'AgencyUserController@rejectInvitation')
        ->name('admin.agencies.reject_invitation')->middleware(['permission:Manage Agency']);

    Route::get('/packages', 'Package\AdminPackageController@index')->name('admin.package.index')->middleware(['permission:Manage Packages']);
    Route::delete('/packages/{package}', 'Package\AdminPackageController@destroy')->name('admin.package.destroy')->middleware(['permission:Manage Packages']);
    Route::get('/packages/{package}/edit', 'Package\AdminPackageController@edit')->name('admin.package.edit')->middleware(['permission:Manage Packages']);
    Route::post('/packages/{package}', 'Package\AdminPackageController@update')->name('admin.package.update')->middleware(['permission:Manage Packages']);
    Route::get('/packages/{package}/show', 'Package\AdminPackageController@show')->name('admin.package.show')->middleware(['permission:Manage Packages']);
    Route::post('/packages/{package}/search-property', 'Package\AdminPackageController@show')->name('admin.package.search.properties')->middleware(['permission:Manage Packages']);


    Route::get('/facebook-post/create', 'Admin\AdminFacebookController@create')->name('admin.facebook.create');
    Route::post('/facebook-post/store', 'Admin\AdminFacebookController@store')->name('admin.facebook.store');

    Route::get('/statistic/overview', 'Admin\StatisticController@index')->name('admin.statistic.index');


//    ajax-call
    Route::post('/agency-change-status', 'AgencyController@changeAgencyStatus')->name('admin.change.agency.status')->middleware(['permission:Manage Agency']);
    Route::post('/change-status', 'PropertyAjaxCallController@changePropertyStatus')->name('admin.change.property.status')->middleware(['permission:Manage Property']);


});

//Facebook Login
Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

//google login
Route::get('google/redirect', 'SocialAuthGoogleController@redirect');
Route::get('google/callback', 'SocialAuthGoogleController@callback');

