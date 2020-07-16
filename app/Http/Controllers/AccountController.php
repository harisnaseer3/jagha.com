<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Dashboard\Role;
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
        $this->middleware('auth');
    }

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
    public function editRoles(Request $request, Role $role)
    {
        $role = DB::table('role_user')->select('role_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->pluck('role_id')->toArray();
        return view('website.account.roles', ['role' => !empty($role) ? $role : null,
            'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    /**
     * Show the form for updating user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function updateRoles(Request $request)
    {
        $individual_roles = $request->input('individual');
        $company_roles = $request->input('company');

        DB::table('role_user')->where('user_id', '=', Auth::user()->getAuthIdentifier())->delete();
        try {
            if (!is_null($individual_roles)) {
                foreach ($individual_roles as $key => $value) {
                    DB::table('role_user')
                        ->updateOrInsert(
                            ['user_id' => Auth::user()->getAuthIdentifier(), 'role_id' => $value]);
                }
            }
            if (!is_null($company_roles)) {
                foreach ($company_roles as $key => $value) {
                    DB::table('role_user')
                        ->updateOrInsert(
                            ['user_id' => Auth::user()->getAuthIdentifier(), 'role_id' => $value]);
                }
            }
            $role = DB::table('role_user')->select('role_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->pluck('role_id')->toArray();
//            return redirect()->route('user_roles.update', $role)->withInput()->with('success', 'User roles have been saved.');
            return view('website.account.roles', ['role' => !empty($role) ? $role : null, 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]])->with('success', 'User roles have been saved.');
        } catch (Throwable $e) {
//            $role = DB::table('role_user')->select('role_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->pluck('role_id')->toArray();
            return redirect()->back()->withInput()->with('error', 'Error updating setting. Try again.');
        }
    }

    public function editSettings(Account $account)
    {
        $account = (new Account)->select('*')->where('user_id', '=', Auth::user()->getAuthIdentifier())->first();
        return view('website.account.settings', ['table_name' => 'accounts', 'account' => $account, 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    public function updateSettings(Request $request, Account $account)
    {
        $validator = Validator::make($request->all(), Account::$rules);

        if ($validator->fails()) {
            return redirect()->route('settings.update', $account)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
        try {
            $account = (New Account)->updateOrCreate(['user_id' => Auth::user()->getAuthIdentifier()], [
                'user_id' => Auth::user()->getAuthIdentifier(),
                'message_signature' => $request->input('message_signature'),
                'email_notification' => $request->input('email_notification'),
                'newsletter' => $request->input('newsletter'),
                'automated_reports' => $request->input('automated_reports'),
                'email_format' => $request->input('email_format'),
                'default_currency' => $request->input('default_currency'),
                'default_area_unit' => $request->input('default_area_unit'),
                'default_language' => $request->input('default_language'),
                'sms_notification' => $request->input('sms_notification')
            ]);

            return view('website.account.settings', ['table_name' => 'accounts', 'account' => $account, 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]])->with('success', 'Your settings are saved.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', 'Error updating setting. Try again.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
