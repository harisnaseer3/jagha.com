<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Agency;
use App\Models\Package;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class PackageController extends Controller
{
    public function index()
    {
        $sub_packages = DB::table('packages')
            ->select(DB::raw('Count(package_properties.property_id) AS added_properties'), 'packages.id', 'packages.type', 'packages.package_for',
                'packages.property_count', 'packages.activated_at', 'packages.status')
            ->where('packages.user_id', '=', Auth::user()->id)
            ->where('packages.status', '=', 'active')
            ->join('package_properties', 'packages.id', '=', 'package_properties.package_id')
            ->groupBy('packages.id', 'packages.type', 'packages.package_for', 'packages.property_count', 'packages.activated_at', 'packages.status')
            ->get()->toArray();

        $req_packages = DB::table('packages')->where('user_id', '=', Auth::user()->id)->where('status', '!=', 'active')->get()->toArray();
//        dd($req_packages);
        return view('website.package.listings', [
            'sub_packages' => $sub_packages,
            'req_packages' => $req_packages,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ]);

    }

    public function create()
    {
        return view('website.package.buy-package', [
            'user_agencies' => Auth::guard('web')->user()->agencies->where('status', 'verified'),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Package::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again.');
        }
        try {
            $package = DB::table('packages')->insertGetId([
                'user_id' => Auth::guard('web')->user()->id,
                'type' => $request->input('package'),
                'package_for' => $request->has('package_for') ? $request->input('package_for') : 'properties',
                'property_count' => $request->input('property_count'),
                'status' => 'pending'
            ]);
            if ($request->has('agency')) {
                $agency = (new Agency)->select('id')->where('id', $request->agency)->first();
                if ($agency) {
                    DB::table('package_agency')->insert([
                        'package_id' => $package,
                        'agency_id' => $agency->id,

                    ]);
                }
            }
            return redirect()->route('package.index')
                ->with('success', 'Request submitted successfully. You will be notified about the progress in 2 hours.');


        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }


    public function destroy(Request $request)
    {
        $package = (new Package)->where('id', '=', $request->input('record_id'))->first();


        if ($package) {
            try {

                $package->status = 'deleted';
                $package->activated_at = null;
                $package->save();


                return redirect()->back()->with('success', 'Package deleted successfully');
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Error deleting record, please try again');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    public function AddProperties(Package $package, Request $request)
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
        $footer_content = (new FooterController)->footerContent();
        return view('website.package.properties.add-properties', [
            'data' => $this->_property_listing($package, $request),
            'package' => $package,
            'sort' => $order,
            'pack_properties' => (new \App\Models\Package)->getPropertiesFromPackageID($package->id),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ]);
    }

    public function _property_listing($package, $request)
    {
        $user = Auth::guard('web')->user()->getAuthIdentifier();
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
//        if ($purpose === 'all') {
        return $this->_listings($status, $user, $package)->where($condition)->orderBy($sort, $order)->paginate($page);

//        }
//        if ($purpose === 'sale') {
//            return $this->_listings($status, $user, $package)->where('purpose', '=', 'sale')->where($condition)->orderBy($sort, $order)->paginate($page);
//        }
//        if ($purpose === 'rent') {
//            return $this->_listings($status, $user, $package)->where('purpose', '=', 'rent')->orderBy($sort, $order)->where($condition)->paginate($page);
//        }
//        if ($purpose === 'wanted') {
//            return $this->_listings($status, $user, $package)->where('purpose', '=', 'wanted')->orderBy($sort, $order)->where($condition)->paginate($page);
//        }
    }

    private function _listings(string $status, string $user, $package)
    {

        $listings = Property:: select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
            'properties.status', 'locations.name AS location', 'cities.name as city', 'properties.views',
            'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
            'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
            'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id', 'properties.cell', 'properties.agency_id', DB::raw("'0' AS quota_used"),
            DB::raw("'0' AS image_views"))
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');

        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            }
            //if user owns agencies{}

            if ($package->package_for != 'Agency') {
                $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);
                $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
                return $listings;
            }
            //get agency from package agency table
            $package_agency_id = Package::getAgencyFromPackageID($package->id);
            $listings = $listings->where('properties.agency_id', '=', $package_agency_id);
            $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
            return $listings;
        }
    }

//    public function searchProperty(Request $request)
//    {
//
//
//    }
}
