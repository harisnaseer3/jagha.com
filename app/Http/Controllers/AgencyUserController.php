<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyUser;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\UserInvite;
use App\Notifications\AddAgencyUser;
use App\Notifications\Property\PropertyActivatedNotification;
use App\Notifications\SendMailToJoinNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgencyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $footer_data = (new FooterController)->footerContent();
        $agency_ids = $user->agencies->pluck('id')->toArray();
        $current_agency_users = User::select('id', 'email', 'name', 'phone', 'city_name', 'is_active')->whereIn('id', DB::table('agency_users')->select('user_id')->whereIn('agency_id', $agency_ids)->pluck('user_id')->toArray())->where('id', '!=', $user->id)->get();

        return view('website.agency-staff.listings', [
            'recent_properties' => $footer_data[0],
            'footer_agencies' => $footer_data[1],
            'current_agency_users' => $current_agency_users

        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store($agency, $user_id = '')
    {
        DB::table('agency_users')->insert([
            ['agency_id' => $agency->id, 'user_id' => $user_id != '' ? $user_id : Auth::user()->getAuthIdentifier()],
        ]);
    }

    public function addStaff()
    {
        $footer_data = (new FooterController)->footerContent();

        return view('website.agency-staff.add-staff', [
            'recent_properties' => $footer_data[0],
            'footer_agencies' => $footer_data[1]

        ]);

    }

    public function addUsers($id)
    {
        if (Auth::guard('admin')->user())
            $user = Auth::guard('admin')->user()->getAuthIdentifier();
        else
            $user = Auth::user()->getAuthIdentifier();
        $current_agency_users = User::select('id', 'email', 'name', 'phone', 'is_active')->whereIn('id', DB::table('agency_users')->select('user_id')->where('agency_id', '=', $id)->pluck('user_id')->toArray())->get();
        $status = '';
        $agency_data = Agency::where('id', '=', $id)->first();

        $data = '{"name":"' . $agency_data->title . '","id":' . $agency_data->id . '}';
        $user_status = [];

        $status_checks = DB::table('notifications')->select('read_at', 'notifiable_id')
            ->where('data', '=', $data)->get();
        foreach ($status_checks as $status_check) {
            $status = '';
            if ($status_check->read_at == null) {
                $status = 'pending';
            } else if (DB::table('agency_users')->where('user_id', '=', $status_check->notifiable_id)->where('agency_id', '=', $agency_data->id)->exists()) {
                $status = 'accepted';
            } else {
                $status = 'rejected';
            }
            $user_status[] = [
                'user_id' => $status_check->notifiable_id,
                'user_email' => User::select('email')->where('id', '=', $status_check->notifiable_id)->first()->email,
                'status' => $status
            ];
        }
        if (Auth::guard('admin')->user()) {
            $data = [
                'users_status' => $user_status,
                'agency' => (new AgencyController)->getAgencyById($id),
                'counts' => (new AgencyController)->getAgencyListingCount($user),
                'current_agency_users' => $current_agency_users
            ];
            return view('website.admin-pages.agency.add_agency_users', $data);
        } else
            $data = [
                'users_status' => $user_status,
                'agency' => (new AgencyController)->getAgencyById($id),
                'counts' => (new AgencyController)->getAgencyListingCount($user),
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1],
                'current_agency_users' => $current_agency_users
            ];
        return view('website.agency.add_agency_users', $data);
    }

    public function storeAgencyUsers(Request $request, string $agency)
    {
        if ($request->city != null && $request->country === 'Pakistan') {
            $request->city_name = $request->city;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string', // +92-511234567
            'mobile' => 'required', // +92-3001234567
            'address' => 'nullable|string',
            'zip_code' => 'nullable|digits:5',
            'country' => 'required|string',
            'community_string' => 'nullable|string',
            'about_yourself' => 'nullable|string|max:4096',
            'upload_new_picture.*' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
            'city_name' => 'nullable|string|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        $user = User::createUser($request->input());
        if (isset($user->id)) {
            DB::table('agency_users')->insert(['agency_id' => $agency, 'user_id' => $user->id]);
            $new_agency = (new Agency)->where('id', $agency)->first();
            if ($request->send_verification_mail === 'Yes') {
                $user->notify(new SendMailToJoinNotification($new_agency));
            }
        }
        return redirect()->back()->with('success', 'Agency user successfully added');

    }

    public function storeStaff(Request $request)
    {
        if ($request->city != null && $request->country === 'Pakistan') {
            $request->city_name = $request->city;
        }
        if ($request->add === 'New User') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'account_password' => ['required', 'string', 'min:8', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
                'phone' => 'nullable|string',
                'mobile' => 'required',
                'address' => 'nullable|string',
                'zip_code' => 'nullable|digits:5',
                'country' => 'required|string',
                'community_string' => 'nullable|string',
                'about_yourself' => 'nullable|string|max:4096',
                'upload_new_picture.*' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
                'city_name' => 'nullable|string|max:255'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        $agency = (new Agency)->where('id', $request->agency_id)->first();
        if ($request->add === 'New User') {
            $user = User::createUser($request->input());
            if (isset($user->id) && isset($agency->id)) {
                DB::table('agency_users')->insert(['agency_id' => $agency->id, 'user_id' => $user->id]);
                if ($request->send_verification_mail === 'Yes') {
                    $user->notify(new SendMailToJoinNotification($agency));
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Error storing record, try again.');
            }

        } elseif ($request->add === 'Existing User') {

            $current_user = User::getUserByEmail($request->email);
            if (isset($current_user->id) && isset($agency->id)) {
                $condition = ['user_id' => $current_user->id, 'agency_id'=> $agency->id];
                $agency_user = (new AgencyUser())->where($condition)->first();
                if(isset($agency_user->id)){
                    return redirect()->back()->withInput()->with('error', 'Error storing record, user has already been registered to the agency');
                }
                DB::table('agency_users')->insert(['agency_id' => $agency->id, 'user_id' => $current_user->id]);
                if ($request->send_verification_mail === 'Yes') {
                    $current_user->notify(new SendMailToJoinNotification($agency));
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Error storing record, try again.');
            }
        }
        else {
            return redirect()->back()->withInput()->with('error', 'Error storing record, try again.');
        }
        return redirect()->back()->with('success', 'Agency user successfully added');

    }

    public function acceptInvitation(Request $request)
    {
        if ($request->ajax()) {
            if (Agency::where('id', $request->agency_id)->exists()) {
                if (User::where('id', $request->user_id)->exists()) {
                    if (!(DB::table('agency_users')->where('agency_id', $request->agency_id)->where('user_id', $request->user_id)->first())) {
                        DB::table('agency_users')->insert(['agency_id' => $request->agency_id, 'user_id' => $request->user_id]);
                    }
                }
            }
            auth()->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('notification_id'));
                })
                ->markAsRead();

            return response()->json(['data' => $request->all(), 'status' => 200]);
        } else {
            return "not found";
        }
    }

    public function rejectInvitation(Request $request)
    {
        if ($request->ajax()) {
            auth()->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('notification_id'));
                })
                ->markAsRead();
            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAgencyUsers(Request $request)
    {
        if ($request->ajax()) {
            $agency = (new Agency)->where('id', $request->input('agency'))->first();
            if ($agency) {
                $city = $agency->city->name;
                $agencies_users_ids = DB::table('agency_users')->select('user_id')
                    ->where('agency_id', $agency->id)
                    ->get()->pluck('user_id')->toArray();

                if (!empty($agencies_users_ids)) {
                    $agencies_users = (new User)->select('name', 'id')
                        ->whereIn('id', $agencies_users_ids)
                        ->get();
                    $users = [];
                    foreach ($agencies_users as $user) {
                        $users += array($user->id => $user->name);
                    }
                    return response()->json(['data' => $users, 'agency' => $agency->toArray(), 'agency_city' => $city, 'status' => 200]);
                }
            }


        } else {
            return "not found";
        }
    }

    public function getAgencyUserData(Request $request)
    {
        if ($request->ajax()) {
            $agency_user = DB::table('users')->select('name', 'cell', 'phone', 'fax', 'email')->where('id', $request->input('user'))->first();

            if ($agency_user) {
                return response()->json(['data' => $agency_user, 'status' => 200]);
            }

        } else {
            return "not found";
        }
    }

    public function agencyUserDestroy(Request $request)
    {
        $current_user = User::getUserById($request->input('agency_user_id'));
        if (empty($current_user)) {
            return redirect()->back()->with('error', 'Something went wrong. User not found');
        }
        $user_status = User::destroyUser($current_user->id);
        if ($user_status === '1') {
            return redirect()->back()->with('success', 'User activated successfully.');
        } elseif ($user_status === '0') {
            return redirect()->back()->with('success', 'User deactived successfully.');

        }
    }

    public function getAgentProperties(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('user_id') && $request->has('agency_id') && $request->has('sort') && $request->has('status') && $request->has('purpose')) {
                $listings = Property::select('properties.id', 'sub_type AS type', 'properties.reference',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id',
                    'properties.cell', 'properties.agency_id')
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->where('properties.agency_id', '=', $request->agency_id)
                    ->where('properties.status', '=', $request->status);
                if ($request->user_id != '0') {
                    $listings = $listings->where('properties.user_id', '=', $request->user_id);
                }
                if ($request->purpose !== 'all') {
                    $listings = $listings->where('properties.purpose', '=', $request->purpose);
                }
                $listings = $listings->whereNull('properties.deleted_at')
                    ->orderBy('id', $request->sort == 'oldest' ? 'ASC' : 'DESC')
                    ->get();

                $data['view'] = View('website.components.user_listings',
                    [
                        'params' => [
                            'status' => 'active',
                            'purpose' => 'sale',
                            'user' => Auth::user()->id,
                            'sort' => 'id',
                            'order' => 'asc',
                            'page' => 1,
                        ],
                        'listings' => [
                            'all' => $listings,
                            'sale' => [],
                            'rent' => [],
                            'wanted' => [],
                            'basic' => [],
                            'silver' => [],
                            'bronze' => [],
                            'golden' => [],
                            'platinum' => [],
                        ],
                    ])->render();
                return $data;

            } else {
                return "try again";
            }
        } else {
            return "not available";
        }

    }
}
