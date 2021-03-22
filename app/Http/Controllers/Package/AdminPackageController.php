<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Agency;
use App\Models\AgencyLog;
use App\Models\Package;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Exception;


class AdminPackageController extends Controller
{
    public function index()
    {
        $sub_packages = DB::table('packages')
            ->select(DB::raw('Count(package_properties.property_id) AS added_properties'), 'packages.id', 'packages.type', 'packages.package_for',
                'packages.property_count', 'packages.activated_at', 'packages.status', 'packages.duration', 'package_agency.agency_id')
            ->where('packages.status', '=', 'active')
            ->Leftjoin('package_properties', 'packages.id', '=', 'package_properties.package_id')
            ->Leftjoin('package_agency', 'packages.id', '=', 'package_agency.package_id')
            ->groupBy('packages.id', 'packages.type', 'packages.package_for', 'packages.property_count', 'packages.activated_at',
                'packages.status', 'package_agency.agency_id')
            ->get()->toArray();


        $req_packages = DB::table('packages')
            ->select('packages.id', 'packages.type', 'packages.package_for', 'packages.property_count', 'packages.status', 'packages.created_at', 'packages.duration', 'package_agency.agency_id')
            ->where('status', '!=', 'active')
            ->leftJoin('package_agency', 'packages.id', '=', 'package_agency.package_id')
            ->get()->toArray();
        return view('website.admin-pages.package.listings', [
            'sub_packages' => $sub_packages,
            'req_packages' => $req_packages,
        ]);

    }

    public function edit(Package $package)
    {
        $agency_id = DB::table('package_agency')
            ->select('package_agency.agency_id AS id')
            ->where('package_agency.package_id', $package->id)
            ->first();
        return view('website.admin-pages.package.edit-package', [
            'agency_id' => $agency_id,
            'package' => $package,
        ]);
    }

    public function update(Package $package, Request $request)
    {
        if ($request->status == 'rejected' && !($request->has('rejection_reason'))) {
            return redirect()->back()->withInput()->with('error', 'Please specify the rejection reason.');
        }
        $validator = Validator::make($request->all(), [
            'property_count' => 'required|min:1',
            'duration' => 'required|min:1',
            'package' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
            $admin = Auth::guard('admin')->user();
            $package->admin_id = $admin->id;
            if ($request->status != 'active') {
                $package->status = $request->status;
                if ($request->status == 'rejected')
                    $package->rejection_reason = $request->rejection_reason;

                //TODO:send email to user about status change along with reason

            } else if ($request->status == 'active') {
                $package->status = $request->status;
                $package->activated_at = Carbon::now()->toDateTimeString();
                $package->expired_at = Carbon::now()->addMonths($package->duration)->toDateTimeString();


                //TODO:send email to user about status change along with expiry date
                $agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id);
                if ($agency) {
                    if ($package->type == 'Silver') {
                        DB::table('agencies')
                            ->where('id', '=', $agency->agency_id)
                            ->update([
                                'key_listing' => 1
                            ]);
                    } else if ($package->type == 'Gold') {
                        DB::table('agencies')
                            ->where('id', '=', $agency->agency_id)
                            ->update(['featured_listing' => 1]);
                    }
                }
            }

            $package->save();

            DB::table('package_logs')->insert([
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'package_id' => $package->id,
                'status' => $package->status,
                'rejection_reason' => $package->rejection_reason,
            ]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }

        return redirect()->route('admin.package.index')->with('success', 'Package status changed to ' . ucwords($package->status) . '.');

    }

    public function show(Package $package, Request $request)
    {
        $order = '';
        if ($request->has('sort')) {
            if ($request->input('sort') == 'oldest') {
                $sort = 'id';
                $order = 'asc';
            } else if ($request->input('sort') == 'newest') {
                $sort = 'id';
                $order = 'desc';
            }
        }
        $package_agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id);

        return view('website.admin-pages.package.package_detail', [
            'data' => $this->_property_listing($package, $request),
            'package' => $package,
            'package_agency'=>$package_agency,
            'sort' => $order,
            'pack_properties' => (new \App\Models\Package)->getPropertiesFromPackageID($package->id),
        ]);
    }

    public function destroy(Request $request)
    {
        $package = (new Package)->where('id', '=', $request->input('record_id'))->first();


        if ($package) {
            try {

                $package->status = 'deleted';
                $package->activated_at = null;
                $package->save();

                //TODO:send mail to user about package deletion + notification


                return redirect()->back()->with('success', 'Package deleted successfully');
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Error deleting record, please try again');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    public function _property_listing($package, $request)
    {
        $user = $package->user_id;
        $sort = 'activated_at';
        $order = 'desc';

        // pagination
        $condition = [];
        if ($request->has('property_id')) {
            $condition = ['properties.id' => $request->input('property_id')];
        }
        if ($request->has('sort')) {
            if ($request->input('sort') == 'oldest') {
                $sort = 'id';
                $order = 'asc';
            } else if ($request->input('sort') == 'newest') {
                $sort = 'id';
                $order = 'desc';
            }
        }

        $page = 10;
        return $this->_getPropertiesByPurpose('all', $condition, 'active', $order, $user, $sort, $page, $package);

    }


    private function _getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page, $package)
    {
        return $this->_listings($status, $user, $package)->where($condition)->orderBy($sort, $order)->paginate($page);
    }

    private function _listings(string $status, string $user, $package)
    {

        $listings = Property:: select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
            'properties.status', 'locations.name AS location', 'cities.name as city', 'properties.views',
            'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
            'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
            'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person',
            'properties.user_id', 'properties.cell', 'properties.agency_id')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');

//        if (!Auth::guard('admin')->user()) {
        if (empty($user)) {
            $user = $package->user_id;
        }
        //if user owns agencies{}
        if ($package->package_for != 'agency') {
            $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);
            $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
            return $listings;
        }
        //get agency from package agency table
        if ($package->package_for == 'agency') {
            $package_agency_id = (new \App\Models\Package)->getAgencyFromPackageID($package->id)->agency_id;
            $listings = $listings->where('properties.agency_id', '=', $package_agency_id);
            $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
            return $listings;
        }
    }

}
