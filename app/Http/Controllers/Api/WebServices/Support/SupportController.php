<?php

namespace App\Http\Controllers\Api\WebServices\Support;

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
        $this->middleware('auth:api');
    }

    public function sendSupportMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'string|required|max:1024|min:25',
            'inquire_type' => 'required|in:property,agency,other',
            'property_id' => 'required_if:inquire_about,=,property',
            'agency_id' => 'required_if:inquire_about,=,agency',
            'topic' => 'required_if:inquire_about,=,other',
            'url' => 'nullable|url',
        ]);
        if ($validator->fails()) {
//            dd($validator);
            return (new \App\Http\JsonResponse)->failed($validator->getMessageBag());

//            return redirect()->back()->withInput()->withErrors($validator)->with('error', 'Error in submitting request, Please resolve the following error(s).');
        }
        try {

            $property_id = null;
            $agency_id = null;
            $topic = null;
            $ticket_id = null;
            $inquire_type = $request->input('inquire_type');
            $last_ticket_id = (new CountTableController)->getSupportCountByType($inquire_type);


            if ($inquire_type == 'property') {
                $property_id = $request->input('property_id');
                if ($last_ticket_id > 0) {
                    $ticket_id = 'SP-' . str_pad($last_ticket_id + 1, 8, '0', STR_PAD_LEFT);

                } else {
                    $ticket_id = 'SP-00000001';
                }


            } elseif ($inquire_type == 'agency') {
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
                'user_id' => auth()->guard('api')->user()->getAuthIdentifier(),
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
            $user = auth()->guard('api')->user();
            event(new NotifyAdminOfSupportMessage($support));
            event(new NotifyUserofSupportTicket($support, $user));
            return (new \App\Http\JsonResponse)->success('Support ticket ' . $support->ticket_id . ' raised successfully.');

        } catch
        (Throwable $e) {
            return (new \App\Http\JsonResponse)->failed('Failed to insert data, Please try again.');
        }
    }


}
