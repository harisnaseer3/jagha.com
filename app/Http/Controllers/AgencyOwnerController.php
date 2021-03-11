<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateDBTables;
use App\Models\Agency;
use App\Models\AgencyLog;
use App\Models\Dashboard\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgencyOwnerController extends Controller
{
    public function edit(Agency $agency)
    {
        if ($agency->user_id !== 1) {
            return redirect()->route('admin.agencies.listings', [
                'status' => 'verified_agencies',
                'purpose' => 'all',
                'user' => Auth::guard('admin')->user()->getAuthIdentifier(),
                'sort' => 'id',
                'order' => 'asc',
                'page' => 200,
            ])->with('error', 'Something went wrong.');
        }
        $city = $agency->city->name;
        $agency->city = $city;

        $counts = (new AgencyController())->getAgencyListingCount(Auth::guard('admin')->user()->getAuthIdentifier());
        return view('website.admin-pages.agency.add_agency_owner',
            ['table_name' => 'users',
                'counts' => $counts,
                'agency' => $agency
            ]
        );

    }

    public function update(Request $request, Agency $agency)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            if (Auth::guard('admin')->user())
                return redirect()->route('admin-agencies-owner-edit', $agency)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
//        dd($request->all());
        $user = User::getUserByEmail($request->email);
        if ($user) {

            $this->dispatch(new UpdateDBTables($agency, $user, Auth::guard('admin')->user()->getAuthIdentifier(), Auth::guard('admin')->user()->name));

            return redirect()->route('admin.agencies.listings', [
                'status' => 'verified_agencies',
                'purpose' => 'all',
                'user' => Auth::guard('admin')->user()->getAuthIdentifier(),
                'sort' => 'id',
                'order' => 'asc',
                'page' => 200,
            ])->with('success', 'Agency Owner has been updated successfully.');


        } else {
            return redirect()->route('admin-agencies-owner-edit', $agency)->withInput()
                ->withErrors($validator->errors())->with('error', 'Error updating record, ' . $request->email . ' not exists in our record. Please enter correct email.');
        }
    }
}
