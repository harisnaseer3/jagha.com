<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\UserInvite;
use App\Notifications\AddAgencyUser;
use App\Notifications\Property\PropertyActivatedNotification;
use App\Notifications\SendMailToJoinNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class AgencyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function addUsers($id)
    {
        if (Auth::guard('admin')->user())
            $user = Auth::guard('admin')->user()->getAuthIdentifier();
        else
            $user = Auth::user()->getAuthIdentifier();
        $current_agency_users = User::select('id', 'email', 'name', 'phone')->whereIn('id', DB::table('agency_users')->select('user_id')->where('agency_id', '=', $id)->pluck('user_id')->toArray())->get();
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
        $user = User::createUser($request->input());
        if(isset($user->id)) {
            DB::table('agency_users')->insert(['agency_id' => $agency, 'user_id' => $user->id]);
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

            $agencies_users_ids = DB::table('agency_users')->select('user_id')->where('agency_id', $request->input('agency'))->get()->pluck('user_id')->toArray();

            if (!empty($agencies_users_ids)) {
                $agencies_users = (new User)->select('name', 'id')
                    ->whereIn('id', $agencies_users_ids)
                    ->get();
                $users = [];
                foreach ($agencies_users as $user) {
                    $users += array($user->id => $user->name);
                }
                return response()->json(['data' => $users, 'status' => 200]);
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
}
