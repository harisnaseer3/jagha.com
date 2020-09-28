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
        $current_agency_users = User::select('id', 'email')->whereIn('id', DB::table('agency_users')->select('user_id')->where('agency_id', '=', $agency)->pluck('user_id')->toArray())->get();

        $agency_id = $agency;
        $users = [];
        $user_emails = $request->input('email');
        $user_ids = $request->input('id');
        $agency_data = Agency::where('id', '=', $agency_id)->first();
        $new_email_users = [];
        $new_id_users = [];
        $existing_email_user = [];
        $existing_id_user = [];
        $already_in_notification_by_email = [];
        $already_in_notification_by_id = [];
        $data = '{"name":"' . $agency_data->title . '","id":' . $agency_data->id . '}';

        foreach ($user_emails as $user_email) {
            if ($user_email) {
                if (User::select('id')->where('email', '=', $user_email)->first()) {
                    if (DB::table('notifications')
                        ->where('notifiable_id', '=', User::select('id')->where('email', '=', $user_email)->first()->id)
                        ->where('data', '=', $data)->exists()) {
                        $already_in_notification_by_email[] = $user_email;
                    } else {
                        $existing_email_user[] = $user_email;
                        $users[] = User::select('id', 'email')->where('email', '=', $user_email)->first();
                    }

                } else {
                    $new_email_users[] = $user_email;
                    DB::table('user_invites')
                        ->updateOrInsert(
                            ['email' => $user_email],
                            ['email' => $user_email]
                        );
                    $new_user = UserInvite::where('email', '=', $user_email)->first();
                    //  send mail to new user
                    Notification::send($new_user, new SendMailToJoinNotification($agency_data));
                }
            }
        }

        foreach ($user_ids as $user_id) {
            if ($user_id) {
                if (User::select('id')->where('id', '=', $user_id)->first()) {
                    if (DB::table('notifications')
                        ->where('notifiable_id', '=', $user_id)
                        ->where('data', '=', $data)->exists()) {
                        $already_in_notification_by_id[] = $user_id;
                    } else {
                        $existing_id_user[] = $user_id;
                        $users[] = User::select('id', 'email')->where('id', '=', $user_id)->first();
                    }
                } else {
                    $new_id_users[] = $user_id;
                }
            }
        }
        if (count($users) > 0) {
            //            send notification to user profile
            Notification::send($users, new AddAgencyUser($agency_data));
        }


        $user = Auth::guard('web')->user()->getAuthIdentifier();
        $user_status = [];

        $status = '';
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
        $data = [
            'users_status' => $user_status,
            'agency' => (new AgencyController)->getAgencyById($agency),
            'counts' => (new AgencyController)->getAgencyListingCount($user),
            'current_agency_users' => $current_agency_users,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ];

        if (count($users) > 0 && (count($new_email_users) > 0 || count($new_id_users) > 0))  #if few users found and some are not found
            return redirect()->route('agencies.add-users', $data)->with('success', 'Agency invitation has been sent to users.' . ' ' . implode(', ', $existing_id_user) . ' ' . implode(', ', $existing_email_user))->with('error', 'User(s) with ID/Email' . ' ' . implode(', ', $new_id_users) . ' ' . implode(', ', $new_email_users) . ' not found. An invitation to join About Pakistan Property Portal has been sent to Email.');
        else if (count($users) > 0 && (count($new_email_users) == 0 && count($new_id_users) == 0)) #if all users found
            return redirect()->route('agencies.add-users', $data)->with('success', 'Agency invitation has been sent to user(s).');
        else if (count($users) == 0 && (count($already_in_notification_by_id) > 0 || count($already_in_notification_by_email) > 0)) #if no users are repeated
            return redirect()->route('agencies.add-users', $data)->with('error', 'User(s) with ID/Email' . ' ' . implode(', ', $new_id_users) . ' ' . implode(', ', $new_email_users) . 'already member(s) of the agency.');
        else if (count($users) == 0 && count($already_in_notification_by_id) == 0 && count($already_in_notification_by_email) == 0) #if no users found
            return redirect()->route('agencies.add-users', $data)->with('error', 'User(s) with ID/Email' . ' ' . implode(', ', $already_in_notification_by_id) . ' ' . implode(', ', $already_in_notification_by_email) . ' not found. An invitation to join About Pakistan Property Portal has been sent to Email.');

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
}
