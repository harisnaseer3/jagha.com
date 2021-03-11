<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
            return redirect()->route('agencies.listings', [
                'status' => 'verified_agencies',
                'purpose' => 'all',
                'user' => Auth::user()->getAuthIdentifier(),
                'sort' => 'id',
                'order' => 'desc',
                'page' => 10,
            ])->with('error', 'Something Went Wrong');
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

            DB::table('agencies')
                ->where('id', '=', $agency->id)
                ->update(
                    ['user_id' => $user->id]
                );
            DB::table('agency_users')
                ->where('agency_id', '=', $agency->id)
                ->update(
                    ['user_id' => $user->id]
                );
            DB::table('properties')
                ->where('agency_id', '=', $agency->id)
                ->update(
                    ['user_id' => $user->id]
                );
            DB::table('property_count_by_user')
                ->updateOrInsert(
                    ['agency_id' => $agency->id],
                    ['user_id' => $user->id]
                );
            $sale_active_count = DB::table('property_count_by_user')->select('agency_count')
                ->where('user_id', '=', $user->id)
                ->where('agency_id', '=', $agency->id)
                ->where('property_purpose', '=', 'sale')
                ->where('property_status', '=', 'active')->first();


            $rent_active_count = DB::table('property_count_by_user')->select('agency_count')
                ->where('user_id', '=', $user->id)
                ->where('agency_id', '=', $agency->id)
                ->where('property_purpose', '=', 'rent')
                ->where('property_status', '=', 'active')->first();
            if ($sale_active_count) {

                $sale_active_count = $sale_active_count->agency_count;

                DB::table('property_count_by_status_and_purposes')->select('property_count')
                    ->where('user_id', '=', 1)
                    ->where('property_purpose', '=', 'sale')
                    ->where('property_status', '=', 'active')
                    ->where('listing_type', '=', 'basic_listing')
                    ->where('property_count', '>=', $sale_active_count)
                    ->decrement('property_count', $sale_active_count);

                DB::table('property_count_by_status_and_purposes')
                    ->where('user_id', '=', $user->id)
                    ->where('property_purpose', '=', 'sale')
                    ->where('property_status', '=', 'active')
                    ->where('listing_type', '=', 'basic_listing')
                    ->increment('property_count', $sale_active_count);
            }
            if ($rent_active_count) {
                $rent_active_count = $rent_active_count->agency_count;
                DB::table('property_count_by_status_and_purposes')
                    ->where('user_id', '=', 1)
                    ->where('property_purpose', '=', 'rent')
                    ->where('property_status', '=', 'active')
                    ->where('listing_type', '=', 'basic_listing')
                    ->where('property_count', '>=', $rent_active_count)
                    ->decrement('property_count', $rent_active_count);

                DB::table('property_count_by_status_and_purposes')
                    ->where('user_id', '=', $user->id)
                    ->where('property_purpose', '=', 'rent')
                    ->where('property_status', '=', 'active')
                    ->where('listing_type', '=', 'basic_listing')
                    ->increment('property_count', $rent_active_count);
            }

            (new AgencyLog)->create([
                'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier(),
                'admin_name' => Auth::guard('admin')->user()->name,
                'agency_id' => $agency->id,
                'agency_title' => $agency->title,
                'status' => 'Add Agency Owner',
                'rejection_reason' => $agency->rejection_reason,
            ]);
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
