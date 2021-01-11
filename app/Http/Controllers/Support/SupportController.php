<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agencies = '';
        $listings = $this->_listings();
        $properties = $listings[0]->get();
        if(count($listings[1]) > 0){
            $agencies = $listings[1];
        }
        elseif(count($listings[2]) > 0){
            $agencies = $listings[2];
        }
        return view('website.support',
            [
                'properties' => $properties,
                'agencies' => $agencies,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);

    }

    public function sendSupportMail(Request $request)
    {
        dd($request->all());
    }

    private function _listings()
    {   $user = Auth::guard('web')->user()->getAuthIdentifier();
        $listings = Property::
        select('properties.id','properties.agency_id')
            ->whereNull('properties.deleted_at');
            //if user owns agencies{}
            $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);

            $ceo_agencies = Agency::where('user_id', '=', $user)->pluck('id')->toArray(); //gives ceo of agency
            $agent_agencies = DB::table('agency_users')->where('user_id', $user)->pluck('agency_id')->toArray();
            if (count($ceo_agencies) > 0) {
                $agency_users = DB::table('agency_users')->whereIn('agency_id', $ceo_agencies)->distinct('user_id')->pluck('user_id')->toArray();
                $ceo_listings = Property::select('properties.id','properties.agency_id')
                    ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agencies)
                    ->whereIn('properties.user_id', $agency_users);
                return [$ceo_listings->union($listings),$ceo_agencies,$agent_agencies];
            } elseif ($agent_agencies > 0) {
                $agent_listings = Property::
                select('properties.id','properties.agency_id')
                    ->whereNull('properties.deleted_at')
                    ->whereIn('properties.agency_id', $agent_agencies)
                    ->where('properties.user_id', $user);
                return [$agent_listings->union($listings),$ceo_agencies,$agent_agencies];
            }
            return [$listings,$ceo_agencies,$agent_agencies];
    }
}
