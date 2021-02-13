<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Dashboard\PropertyRole;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['logout', 'userLogout']);
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
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
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing user roles.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRoles(Request $request, PropertyRole $role)
    {
//        dd(Auth::user()->roles);
//        dd(Auth::user()->roles->count()>0);
//        dd(!empty(Auth::user()->roles));
//        Auth::user()->roles[0]->name;
        return view('website.account.roles',
            [
                'notifications' => Auth()->user()->unreadNotifications,
                'role' => Auth::guard('web')->user()->roles->count() > 0 ? Auth::guard('web')->user()->roles[0]->name : null,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    /**
     * Show the form for updating user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function updateRoles(Request $request)
    {
        $role = '';
        if ($request->input('user_roles') === 'Other')
            $role = $request->input('new_role');
        else
            $role = $request->input('user_roles');


        $role_id = '';
        if (DB::table('property_roles')->select('id', 'name')->where('name', '=', $role)->first())
            $role_id = DB::table('property_roles')->select('id')->where('name', '=', $role)->first()->id;
        else
            $role_id = DB::table('property_roles')->insertGetId(['name' => $role]);
        DB::table('property_role_user')->where('user_id', '=', Auth::guard('web')->user()->getAuthIdentifier())->delete();
        try {
            if (!is_null($role_id)) {
                DB::table('property_role_user')
                    ->updateOrInsert(['user_id' => Auth::guard('web')->user()->getAuthIdentifier()],
                        ['user_id' => Auth::guard('web')->user()->getAuthIdentifier(), 'property_role_id' => $role_id]);
            }
            return redirect()->route('user_roles.update',
                ['role' => !empty($role) ? $role : null,
                    'recent_properties' => (new FooterController)->footerContent()[0],
                    'footer_agencies' => (new FooterController)->footerContent()[1]
                ])->with('success', 'User roles have been saved.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating setting. Try again.');
        }
    }

    public function editSettings(Account $account)
    {
        $account = (new Account)->select('*')->where('user_id', '=', Auth::guard('web')->user()->getAuthIdentifier())->first();
        return view('website.account.settings', [
            'notifications' => Auth()->user()->unreadNotifications,
            'table_name' => 'accounts',
            'account' => $account,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    public function updateSettings(Request $request, Account $account)
    {
        $validator = Validator::make($request->all(), Account::$rules);

        if ($validator->fails()) {
            return redirect()->route('settings.update', $account)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
        try {
            $account = (new Account)->updateOrCreate(['user_id' => Auth::guard('web')->user()->getAuthIdentifier()], [
                'user_id' => Auth::guard('web')->user()->getAuthIdentifier(),
                'message_signature' => $request->input('message_signature'),
                'email_notification' => $request->input('email_notification'),
                'newsletter' => $request->input('newsletter'),
                'automated_reports' => $request->input('automated_reports'),
//                'email_format' => $request->input('email_format'),
                'email_format' => 'TEXT',
                'default_currency' => $request->input('default_currency'),
                'default_area_unit' => $request->input('default_area_unit'),
                'default_language' => $request->input('default_language'),
                'sms_notification' => $request->input('sms_notification')
            ]);

//            return view('website.account.settings',
//                ['table_name' => 'accounts', 'account' => $account, 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]])
//                ->with('success', 'Your settings are saved.');
            return redirect()->route('settings.update',
                ['notifications' => Auth()->user()->unreadNotifications,
                    'table_name' => 'accounts', 'account' => $account,
                    'recent_properties' => (new FooterController)->footerContent()[0],
                    'footer_agencies' => (new FooterController)->footerContent()[1]])
                ->with('success', 'Your settings are saved.');

        } catch (Throwable $e) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', 'Error updating setting. Try again.');
        }
    }
//
//    public function logout()
//    {
//        Auth::guard('web')->guard('web')->logout();
//        return redirect()->route('home');
//    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect(route('home'));
    }
}
