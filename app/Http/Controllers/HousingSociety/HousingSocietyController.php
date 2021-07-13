<?php

namespace App\Http\Controllers\HousingSociety;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\MetaTagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HousingSocietyController extends Controller
{
    public function getSocietiesData(Request $request)
    {
        $footer_content = (new FooterController)->footerContent();
        $data = [

            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.housing_societies_status', $data);

    }
}
