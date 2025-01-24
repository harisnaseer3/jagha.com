<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Classes\Referred;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferringSiteController extends Controller
{
    public static function get($args = array())
    {

        $number = (isset($args['number']) ? $args['number'] : 10);

        // Get List Top Referring
        try {
            $response = Referred::getTop($number);
        } catch (\Exception $e) {
            $response = array();
        }

        // Check For No Data Meta Box
        if (count($response) < 1) {
            $response = array();
        }

        // Response
        return $response;
    }
}
