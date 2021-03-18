<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use IpLocation;
use Browser;

class TestController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $ip = $_SERVER['REMOTE_ADDR'];
        $country = '';
        $city = '';
        if ($ip_location = IpLocation::get($ip)) {
            $country = $ip_location->countryName;
            $city = $ip_location->cityName;
            if ($country == null)
                $country = (new CountryController())->Country_name();
            if ($city == '')
                $city = (new CountryController())->city_name();
        } else {
            $country = 'unavailable';
            $city = 'unavailable';
        }
        print($ip_location->countryName
            . ',' . $ip_location->cityName);
    }
}
