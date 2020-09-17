<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Notifications\AddAgencyUser;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($agency)
    {
        DB::table('agency_users')->insert([
            ['agency_id' => $agency->id, 'user_id' => Auth::user()->getAuthIdentifier()],
        ]);
    }

    public function addUsers($id)
    {
        $user = Auth::user()->getAuthIdentifier();
        $current_agency_users = User::select('id','email','name','phone')->whereIn('id',DB::table('agency_users')->select('user_id')->where('agency_id','=',$id)->pluck('user_id')->toArray())->get();

        $data = [
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
        $agency_id = $agency;
        $users = [];
        $user_emails = $request->input('email');
        $user_ids = $request->input('id');
        foreach ($user_emails as $user_email) {
            if ($user_email) {
                $users[] = User::select('id')->where('email', '=', $user_email)->first();
            }
        }
        foreach ($user_ids as $user_id) {
            if ($user_id) {
                $users[] = User::select('id')->where('id', '=', $user_id)->first();
            }
        }

        $agency_data = Agency::where('id', '=', $agency_id)->first();
        Notification::send($users, new AddAgencyUser($agency_data));
        $user = Auth::user()->getAuthIdentifier();

        $data = [
            'agency' => (new AgencyController)->getAgencyById($agency),
            'counts' => (new AgencyController)->getAgencyListingCount($user),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ];
//        return view('website.agency.add_agency_users', $data);
        return redirect()->route('agencies.add-users', $data)->with('success', 'Agency invitation has been sent to users');

    }

    public function acceptInvitation(Request $request)
    {
        if ($request->ajax()) {
            if (User::where('id', $request->user_id)->exists() && Agency::where('id', $request->agency_id)->exists()) {
                if (!(DB::table('agency_users')->where('agency_id', $request->agency_id)->where('user_id', $request->user_id)->first())) {
                    DB::table('agency_users')->insert(['agency_id' => $request->agency_id, 'user_id' => $request->user_id]);
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
