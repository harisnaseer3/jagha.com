<?php

namespace App\Http\Controllers\Support;

use App\Events\NotifyAdminOfNewProperty;
use App\Events\NotifyAdminOfSupportMessage;
use App\Events\NotifyUserofSupportTicket;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CountTableController;
use App\Models\Agency;
use App\Models\Property;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FooterController;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;
use IpLocation;

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
        if (count($listings[1]) > 0) {
            $agencies = $listings[1];
        } elseif (count($listings[2]) > 0) {
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

        $validator = Validator::make($request->all(), Support::$rules);
        if ($validator->fails()) {
//            dd($validator);
            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error in submitting request, Please resolve the following error(s).');
        }
        try {

            $property_id = null;
            $agency_id = null;
            $topic = null;
            $ticket_id = null;
            $inquire_type = $request->input('inquire_type');
            $last_ticket_id = (new CountTableController)->getSupportCountByType($inquire_type);


            if ($inquire_type === 'Property') {
                $property_id = $request->input('property_id');
                if ($last_ticket_id > 0) {
                    $ticket_id = 'SP-' . str_pad($last_ticket_id + 1, 8, '0', STR_PAD_LEFT);

                } else {
                    $ticket_id = 'SP-00000001';
                }


            } elseif ($inquire_type === 'Agency') {
                $agency_id = $request->input('agency_id');
                if ($last_ticket_id > 0) {
                    $ticket_id = 'SA-' . str_pad($last_ticket_id + 1, 8, '0', STR_PAD_LEFT);

                } else {
                    $ticket_id = 'SA-00000001';

                }
            } else {
                if ($last_ticket_id > 0) {
                    $ticket_id = 'SO-' . str_pad($last_ticket_id + 1, 8, '0', STR_PAD_LEFT);
                } else {
                    $ticket_id = 'SO-00000001';

                }
            }
            $ip = $_SERVER['REMOTE_ADDR'];
            $country = '';
            if ($ip_location = IpLocation::get($ip)) {
                $country = $ip_location->countryName;
                if ($country == null)
                    $country = (new CountryController())->Country_name();
            } else
                $country = 'unavailable';

            $support = (new Support)->Create([
                'user_id' => Auth::guard('web')->user()->getAuthIdentifier(),
                'url' => $request->input('url'),
                'ip_location' => $country,
                'message' => $request->input('message'),
                'inquire_about' => $inquire_type,
                'property_id' => $property_id,
                'agency_id' => $agency_id,
                'topic' => $inquire_type == 'Other' ? $request->input('topic') : null,
                'ticket_id' => $ticket_id

            ]);

            (new CountTableController)->updateSupportCountByType($inquire_type);
            $user = Auth::guard('web')->user();
            event(new NotifyAdminOfSupportMessage($support));
            event(new NotifyUserofSupportTicket($support, $user));

            return redirect()->back()->with('success', 'Support ticket ' . $support->ticket_id . ' raised successfully.');

        } catch
        (Throwable $e) {
//            dd($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error in submitting request, Please try again.');
        }
    }

    private function _listings()
    {
        $user = Auth::guard('web')->user()->getAuthIdentifier();
        $listings = Property::
        select('properties.id', 'properties.agency_id', 'properties.title')
            ->whereNull('properties.deleted_at');
        //if user owns agencies{}
        $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);

        $ceo_agencies = Agency::where('user_id', '=', $user)->pluck('id')->toArray(); //gives ceo of agency
        $agent_agencies = DB::table('agency_users')->where('user_id', $user)->pluck('agency_id')->toArray();
        if (count($ceo_agencies) > 0) {
            $agency_users = DB::table('agency_users')->whereIn('agency_id', $ceo_agencies)->distinct('user_id')->pluck('user_id')->toArray();
            $ceo_agent_agencies = DB::table('agency_users')
                ->where('user_id', '=', $user)
                ->whereNotIn('agency_id', $ceo_agencies)->pluck('agency_id')->toArray();
            $ceo_listings = Property::select('properties.id', 'properties.agency_id', 'properties.title')
                ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agencies)
                ->whereIn('properties.user_id', $agency_users);

            $ceo_agent_listings = Property::select('properties.id', 'properties.agency_id', 'properties.title')
                ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agent_agencies)
                ->where('properties.user_id', $user);


            return [$ceo_listings->unionAll($listings)->unionAll($ceo_agent_listings), array_unique(array_merge($ceo_agencies, $ceo_agent_agencies)), $agent_agencies];
        } elseif ($agent_agencies > 0) {
            $agent_listings = Property::
            select('properties.id', 'properties.agency_id', 'properties.title')
                ->whereNull('properties.deleted_at')
                ->whereIn('properties.agency_id', $agent_agencies)
                ->where('properties.user_id', $user);
            return [$agent_listings->union($listings), $ceo_agencies, $agent_agencies];
        }
        return [$listings, $ceo_agencies, $agent_agencies];
    }

}
