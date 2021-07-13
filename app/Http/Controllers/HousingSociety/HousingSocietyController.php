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
        $db_con = DB::connection('mysql3');

        $status = $db_con->table('status')->get();

        $authority = $db_con->table('authorities')->select('id', 'title')->get();

        $divisions = $db_con->table('divisions')->get();

        $district = $db_con->table('districts')->get();

        $footer_content = (new FooterController)->footerContent();


        $data = [

            'status' => $status,
            'authority' => $authority,
            'division' => $divisions,
            'district' => $district,
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.housing_societies_status', $data);

    }

    function getSocietiesAjaxData(Request $request)
    {
        if ($request->ajax()) {
            $db_con = DB::connection('mysql3');

            $societies = $db_con->table('societies')
                ->select('societies.id', 'societies.name',
                    'status.title as status',
                    'societies.area',
                    'cities.title as city', 'districts.title as district', 'divisions.title as division', 'authorities.title as authority')
                ->join('status', 'societies.status_id', '=', 'status.id')
                ->join('districts', 'societies.district_id', '=', 'districts.id')
                ->join('divisions', 'societies.division_id', '=', 'divisions.id')
                ->join('authorities', 'societies.authority_id', '=', 'authorities.id')
                ->join('cities', 'societies.city_id', '=', 'cities.id')
                ->orderBy('societies.id', 'ASC')
                ->get()->toArray();

            $data['view'] = View('website.components.societies-block',
                ['societies' => $societies,
                ])->render();
            return $data;
        }
    }
}
