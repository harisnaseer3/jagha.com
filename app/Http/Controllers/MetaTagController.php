<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Property;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;
use Spatie\SchemaOrg\Schema;

class MetaTagController extends Controller
{
//    display tags on page
    public function addMetaTags()
    {
        SEOMeta::setTitle('About Pakistan Property Portal - Buy Sell Rent Homes & Properties In Pakistan');
        SEOMeta::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');

        OpenGraph::setTitle('Pakistan Property Real Estate - Sell Buy Rent Homes & Properties In Pakistan');
        OpenGraph::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/logo/logo-with-text-200x200.png'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);

        TwitterCard::setTitle('About Pakistan Property Portal - Buy Sell Rent Homes & Properties In Pakistan');
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');
        TwitterCard::addImage(asset('img/logo/logo-with-text-200x200.png'));

        SEOMeta::addMeta('site_name', env('APP_NAME'), 'name');
        SEOMeta::addMeta('image', asset('img/logo/logo-with-text-200x200.png'), 'itemprop');
        SEOMeta::addMeta('description', 'About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.', 'itemprop');
    }

    public function addMetaTagsAccordingToCity($city)
    {
        SEOMeta::setTitle('Property and Real Estate for Sell in ' . $city);
        SEOMeta::setDescription('Find properties for Sale in ' . $city . ' within your budget on About Pakistan Property Portal. Get complete details of properties and available amenities');

        OpenGraph::setTitle('Property and Real Estate for Sell in ' . $city);
        OpenGraph::setDescription('Find properties for Sale in ' . $city . ' within your budget on About Pakistan Property Portal. Get complete details of properties and available amenities');
        /* change url according to seo url */
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/logo/logo-with-text-200x200.png'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);

        TwitterCard::setTitle('Property and Real Estate for Sell in ' . $city);
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription('Find properties for Sale in ' . $city . ' within your budget on About Pakistan Property Portal. Get complete details of properties and available amenities');
        TwitterCard::addImage(asset('img/logo/logo-with-text-200x200.png'));

        SEOMeta::addMeta('site_name', env('APP_NAME'), 'name');
        SEOMeta::addMeta('image', asset('img/logo/logo-with-text-200x200.png'), 'itemprop');
        SEOMeta::addMeta('description', 'Find properties for Sale in ' . $city . ' within your budget on About Pakistan Property Portal. Get complete details of properties and available amenities');
    }

    public function addMetaTagsAccordingToPropertyDetail($property)
    {
        SEOMeta::setTitle($property->title . ' For ' . $property->purpose . ' in ' . $property->location . ', ' . $property->city . ' ' . $property->reference . ' - About Pakistan Property Portal');
        SEOMeta::setDescription($property->location . ' - ' . $property->city . ' Property, ' . number_format($property->land_area) . ' ' . $property->area_unit . ' ' . $property->title . ' in ' . $property->location . ' ' . $property->city . ' with ' . ' Area ' . number_format($property->land_area) . ' ' . $property->area_unit . ' and Demand ' . \Illuminate\Support\Str::limit(explode(',', Helper::getPriceInWords($property->price))[0], 10, $end = '...'));

        OpenGraph::setTitle($property->title . ' For ' . $property->purpose . ' in ' . $property->location . '. ' . $property->city . $property->reference . ' - About Pakistan Property Portal');
        OpenGraph::setDescription($property->location . ' - ' . $property->city . ' Property, ' . number_format($property->land_area) . ' ' . $property->area_unit . ' ' . $property->title . ' in ' . $property->location . ' ' . $property->city . ' with ' . ' Area ' . number_format($property->land_area) . ' ' . $property->area_unit . ' and Demand ' . \Illuminate\Support\Str::limit(explode(',', Helper::getPriceInWords($property->price))[0], 10, $end = '...'));
        /* change url according to seo url */
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/logo/logo-with-text-200x200.png'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);

        TwitterCard::setTitle($property->title . ' For ' . $property->purpose . ' in ' . $property->location . ', ' . $property->city . $property->reference . ' - About Pakistan Property Portal');
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription($property->location . ' - ' . $property->city . ' Property, ' . number_format($property->land_area) . ' ' . $property->area_unit . ' ' . $property->title . ' in ' . $property->location . ' ' . $property->city . ' with ' . ' Area ' . number_format($property->land_area) . ' ' . $property->area_unit . ' and Demand ' . \Illuminate\Support\Str::limit(explode(',', Helper::getPriceInWords($property->price))[0], 10, $end = '...'));
        TwitterCard::addImage(asset('img/logo/logo-with-text-200x200.png'));

        SEOMeta::addMeta('site_name', env('APP_NAME'), 'name');
        SEOMeta::addMeta('image', asset('img/logo/logo-with-text-200x200.png'), 'itemprop');
        SEOMeta::addMeta('description', $property->location . ' - ' . $property->city . ' Property, ' . number_format($property->land_area) . ' ' . $property->area_unit . ' ' . $property->title . ' in ' . $property->location . ' ' . $property->city . ' with ' . ' Area ' . number_format($property->land_area) . ' ' . $property->area_unit . ' and Demand ' . \Illuminate\Support\Str::limit(explode(',', Helper::getPriceInWords($property->price))[0], 10, $end = '...'));
    }

    public function addScriptJsonldTag()
    {
        $localBusiness = Schema::localBusiness()
            ->name('About Pakistan Property Portal')
            ->description('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.')
            ->url(URL::current())
            ->telephone('+92 51 4862317')
            ->email('info@aboutpakistan.com')
            ->image(Schema::imageObject()->url(asset('img/logo/logo-with-text-200x200.png')))
            ->logo(Schema::imageObject()->url(asset('img/logo/logo-with-text-200x200.png')))
            ->address(Schema::postalAddress()->streetAddress('I-8')->addressLocality('Islamabad')->addressRegion('punjab')->postalCode('44000')->addressCountry(Schema::country()->name('Pakistan')));
        return $localBusiness;
    }

    public function addMetaTagsOnBlog()
    {
        SEOMeta::setTitle('A blog about real estate, lifestyle and tourism in Pakistan | Property Blog');
        SEOMeta::setDescription('Property Management blog is your go-to place for real estate investment trends, property market analysis, lifestyle, home decor tips, tourism and much more in Pakistan.');

        OpenGraph::setTitle('A blog about real estate, lifestyle and tourism in Pakistan | Property Blog');
        OpenGraph::setDescription('About Pakistan Property blog is your go-to place for real estate investment trends, property market analysis, lifestyle, home decor tips, tourism and much more in Pakistan.');
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/logo/logo-with-text-200x200.png'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);

        TwitterCard::setTitle('A blog about real estate, lifestyle and tourism in Pakistan | Property Blog');
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription('About Pakistan Property blog is your go-to place for real estate investment trends, property market analysis, lifestyle, home decor tips, tourism and much more in Pakistan.');
        TwitterCard::addImage(asset('img/logo/logo-with-text-200x200.png'));

        SEOMeta::addMeta('site_name', env('APP_NAME'), 'name');
        SEOMeta::addMeta('image', asset('img/logo/logo-with-text-200x200.png'), 'itemprop');
        SEOMeta::addMeta('description', 'About Pakistan Property, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.', 'itemprop');

    }

    public function addScriptJsonldOnBlogOrganization()
    {
        $blogOrganization = Schema::organization()
            ->name('About Pakistan Property Portal')
            ->url(URL::current())
            ->email('info@aboutpakistan.com')
            ->logo(Schema::imageObject()->url(asset('img/logo/logo-with-text-200x200.png')));
        return $blogOrganization;

    }

    public function addscriptJsonldWebsite()
    {
        $blogWebsite = Schema::webSite()
            ->name('A blog about real estate, lifestyle and tourism in Pakistan | About Pakistan Property Blog')
            ->url(URL::current());
        return $blogWebsite;

    }

    public function addMetaTagsOnDetailBlog($result)
    {

        $result = $result[0];
        SEOMeta::setTitle($result->post_title);
        SEOMeta::setDescription(\Illuminate\Support\Str::limit(strip_tags($result->post_title), 69, $end = '...'));

        OpenGraph::setTitle($result->post_title);
        OpenGraph::setDescription(\Illuminate\Support\Str::limit(strip_tags($result->post_title), 69, $end = '...'));
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/blogs/' . $result->image));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);
        OpenGraph::setType('article');
        OpenGraph::setSiteName('A blog about real estate, lifestyle and tourism in Pakistan | About Pakistan Property Blog');

        TwitterCard::setTitle($result->post_title);
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription(\Illuminate\Support\Str::limit(strip_tags($result->post_title), 69, $end = '...'));
        TwitterCard::addImage(asset('img/blogs/' . $result->image));


        SEOMeta::addMeta('site_name', 'A blog about real estate, lifestyle and tourism in Pakistan | About Pakistan Property Blog', 'name');
        SEOMeta::addMeta('article:section', $result->source);
        SEOMeta::addMeta('article:tag', $result->post_title);
    }

    public function addMetaTagsOnPartnersListing(){
        SEOMeta::setTitle('About Pakistan Property Partners - Real Estate Property Agencies in Pakistan');
        SEOMeta::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');

        OpenGraph::setTitle('About Pakistan Property Partners - Real Estate Property Agencies in Pakistan');
        OpenGraph::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');
        OpenGraph::setUrl(URL::current());
        OpenGraph::addProperty('image', asset('img/logo/logo-with-text-200x200.png'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', ['en-us']);

        TwitterCard::setTitle('AboutPakistan Property Partners - Real Estate Property Agencies in Pakistan');
        TwitterCard::setSite('@aboutpk_');
        TwitterCard::setDescription('About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.');
        TwitterCard::addImage(asset('img/logo/logo-with-text-200x200.png'));

        SEOMeta::addMeta('site_name', env('APP_NAME'), 'name');
        SEOMeta::addMeta('image', asset('img/logo/logo-with-text-200x200.png'), 'itemprop');
        SEOMeta::addMeta('description', 'About Pakistan Property Portal, A property portal based in Pakistan - offering service to property buyers, sellers, landlords and to real estate agents in Karachi Lahore Islamabad and all over Pakistan.', 'itemprop');

    }
}
