<?php

namespace App\Http\Controllers\HousingSociety;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\MetaTagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HousingSocietyController extends Controller
{
    public function getSocietiesData()
    {
        $db_con = DB::connection('mysql3');

        $status = $db_con->table('status')->select('id', 'title')->get();

        $authority = $db_con->table('authorities')->select('id', 'title')->get();

        $divisions = $db_con->table('divisions')->select('id', 'title','authority_id')->get();

        $district = $db_con->table('districts')->select('id', 'title','division_id','isDevelopmentAuthority')->get();

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

    function SocietiesSearch(Request $request)
    {
        if ($request->ajax()) {
            $status_id = -1;
            $district_id = -1;
            $division_id = -1;
            $authority_id = -1;

            if ($request->has('status')) $status_id = $request->status;
            if ($request->has('division')) $division_id = $request->division;
            if ($request->has('district')) $district_id = $request->district;
            if ($request->has('authority')) $authority_id = $request->authority;


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
                ->join('cities', 'societies.city_id', '=', 'cities.id');
            if ($status_id != -1)
                $societies = $societies->where('societies.status_id', $status_id);
            if ($authority_id != -1)
                $societies = $societies->where('societies.authority_id', $authority_id);
            if ($district_id != -1)
                $societies = $societies->where('societies.district_id', $district_id);
            if ($division_id != -1)
                $societies = $societies->where('societies.division_id', $division_id);


            $societies = $societies
                ->orderBy('societies.id', 'ASC')
                ->get()->toArray();

            $data['view'] = View('website.components.societies-block',
                ['societies' => $societies,
                ])->render();
            return $data;
        }
    }
}
