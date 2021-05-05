<?php

namespace App\Http\Controllers\HitRecord;

use App\Events\LogErrorEvent;
use App\Http\Controllers\Admin\Statistics\ExclusionController;
use App\Http\Controllers\Admin\Statistics\PageController;
use App\Http\Controllers\Admin\Statistics\SearchEngineController;
use App\Http\Controllers\Admin\Statistics\VisitController;
use App\Http\Controllers\Admin\Statistics\VisitorController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Browser;
use Illuminate\Support\Facades\Route;
use IpLocation;


class HitController extends Controller
{
    /**
     * Get Visitor information and Record To DB
     *
     * @throws \Exception
     */
    public static function record()
    {

        # Check Exclusion This Hits
        $exclusion = ExclusionController::check();

        # Record Hits Exclusion
        if ($exclusion['exclusion_match'] === true) {
            ExclusionController::record($exclusion);
        }
        # Record User Visits
        if ($exclusion['exclusion_match'] === false) {
            VisitController::record();
        }
        if ($exclusion['exclusion_match'] === false) {
            $visitor_id = VisitorController::record($exclusion);
        }

        # Record Search Engine
//        if (isset($visitor_id) and $visitor_id > 0 and $exclusion['exclusion_match'] === false) {
//            SearchEngineController::record(array('visitor_id' => $visitor_id));
//        }

        # Record Pages
        if ($exclusion['exclusion_match'] === false) {
            $page_id = PageController::record();

        }
        # Record Visitor Relation Ship
        if ($exclusion['exclusion_match'] === false) {
            if (isset($visitor_id) and $visitor_id > 0) {
                if (isset($page_id) and $page_id > 0) {
                    VisitorController::save_visitors_relationships($page_id, $visitor_id);
                }
                else{
                    event(new LogErrorEvent('Page id not found', 'Error in visitor controller save_visitors_relationships method.'));
                }
            }
            else {
                event(new LogErrorEvent('Visitor id not found', 'Error in visitor controller save_visitors_relationships method.'));
            }
        }
//        if (isset($visitor_id) and $visitor_id > 0 and isset($page_id) and $page_id > 0) {
//            VisitorController::save_visitors_relationships($page_id, $visitor_id);
//        }
//        if (isset($visitor_id) and $visitor_id > 0) {
//            if (isset($page_id) and $page_id > 0) {
//                VisitorController::save_visitors_relationships($page_id, $visitor_id);
//            }
//            else{
//                event(new LogErrorEvent('Page id not found', 'Error in visitor controller save_visitors_relationships method.'));
//            }
//        } else {
//            event(new LogErrorEvent('Visitor id not found', 'Error in visitor controller save_visitors_relationships method.'));
//        }

    }

    public static function getIP()
    {
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip ?: '0.0.0.0';
    }

    public static function getUserAgent()
    {

        // Get Http User Agent
        // $user_agent = $_SERVER['HTTP_USER_AGENT'];


        $pattern = '/[a-zA-Z]/';
        $pattern_2 = '/[0-9].*$/';
        $browser = Browser::browserName();
        $browser_name = isset($browser) ? trim(preg_replace($pattern_2, ' ', $browser)) : 'Unknown';
        $version = isset($browser) ? trim(preg_replace($pattern, ' ', $browser)) : '0';

        $platform = Browser::platformName();
        return array(
            'browser' => (isset($browser_name)) ? $browser_name : 'Unknown',
            'platform' => (isset($platform)) ? $platform : 'Unknown',
            'version' => (isset($version)) ? $version : 'Unknown'
        );
    }

    public static function getCountry($ip)
    {
        $country = '';
        if ($ip_location = IpLocation::get($ip)) {
            $country = $ip_location->countryCode;
            if ($country == null)
                $country = (new CountryController())->country_code($ip);
        } else {
            $country = 'Unknown';
        }
        return $country;
    }

}
