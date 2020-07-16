<?php

namespace App\Helpers;

class Helper
{
    static function getPriceInWords($value)
    {
        $val = intval(str_replace(',', '', $value));
        $valStr = '';
        if ($val >= 1000) {
            if ($val >= 1000000000) {
                $valStr .= floor($val / 1000000000) . ' Arab';
                $val %= 1000000000;
            }
            if ($val >= 10000000) {
                if ($valStr) $valStr .= ', ';
                $valStr .= floor($val / 10000000) . ' Crore';
                $val %= 10000000;
            }
            if ($val >= 100000) {
                if ($valStr) $valStr .= ', ';
                $valStr .= floor($val / 100000) . ' Lac';
                $val %= 100000;
            }
            if ($val >= 1000) {
                if ($valStr) $valStr .= ', ';
                $valStr .= floor($val / 1000) . ' Thousand';
                $val %= 1000;
            }
            if ($val > 0) {
                $valStr .= ' ' . ($valStr ? ' ' : '') . $val;
            }
        }
        return $valStr;
    }

//    static function reset_query_params()
//    {
//        $remove_params = ['property_purpose', 'property_type', 'city', 'location', 'min_price', 'max_price', 'min_area', 'max_area', 'area_unit', 'bedrooms'];
//        $url = url()->current(); // get the base URL - everything to the left of the "?"
//        $query = request()->query(); // get the query parameters (what follows the "?")
//
//        foreach ($remove_params as $param) {
//            unset($query[$param]); // loop through the array of parameters we wish to remove and unset the parameter from the query array
//        }
//        $add_params = ['property_purpose' => 'Buy', 'property_type' => 'Homes', 'city' => 'Islamabad', 'location' => '', 'min_price' => '0', 'max_price' => 'any',
//            'min_area' => '0', 'max_area' => 'any', 'area_unit' => 'Marla', 'bedrooms' => 'All'];
//        $query = array_merge(
//            request()->query(),
//            $add_params
//        ); // merge the existing query parameters with the ones we want to add
//
//        return url()->current() . '?' . http_build_query($query); // rebuild the URL with the new parameters array
//    }
}

