<?php

namespace App\Http\Controllers\Package;

use App\Events\AddPropertyInPackageEvent;
use App\Events\NotifyAdminOfPackageRequestEvent;
use App\Events\NotifyAdminOfSupportMessage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Admin;
use App\Models\Agency;
use App\Models\Package;
use App\Models\Property;
use App\Notifications\PendingPackageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Car;
use Throwable;

class PackageController extends Controller
{
    public function index()
    {
        $sub_packages = DB::table('packages')
            ->select(DB::raw('Count(package_properties.property_id) AS added_properties'), 'packages.id', 'packages.type', 'packages.package_for',
                'packages.property_count', 'packages.activated_at', 'packages.status', 'packages.duration', 'package_agency.agency_id')
            ->where('packages.user_id', '=', Auth::user()->id)
            ->where('packages.status', '=', 'active')
            ->Leftjoin('package_properties', 'packages.id', '=', 'package_properties.package_id')
            ->Leftjoin('package_agency', 'packages.id', '=', 'package_agency.package_id')
            ->groupBy('packages.id', 'packages.type', 'packages.package_for', 'packages.property_count', 'packages.activated_at',
                'packages.status', 'package_agency.agency_id')
            ->get()->toArray();

        $req_packages = DB::table('packages')
            ->select('packages.id', 'packages.type', 'packages.package_for', 'packages.property_count',
                'packages.status', 'packages.created_at', 'packages.duration', 'package_agency.agency_id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '!=', 'active')
            ->Leftjoin('package_agency', 'packages.id', '=', 'package_agency.package_id')
            ->get()->toArray();
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
                'duration' => $request->input('duration'),
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
            //TODO: send admin email about package registration
            event(new NotifyAdminOfPackageRequestEvent($package));
//            $admins = Admin::getAdminsByRoleName('Emails Administrator');
//            Notification::send($admins, new PendingPackageNotification($package));

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
        $package_agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id);
        $footer_content = (new FooterController)->footerContent();
        return view('website.package.properties.add-properties', [
            'data' => $this->_property_listing($package, $request),
            'package' => $package,
            'sort' => $order,
            'package_agency' => $package_agency,
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
        return $this->_listings($status, $user, $package)->where($condition)->orderBy($sort, $order)->paginate($page);
    }

    private function _listings(string $status, string $user, $package)
    {

        $listings = Property:: select('properties.id', 'sub_type AS type', 'properties.purpose',
            'properties.status', 'locations.name AS location', 'cities.name as city', 'properties.views',
            'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by',
            'properties.silver_listing', 'properties.golden_listing',
            'price', 'properties.created_at AS listed_date', 'properties.created_at',
            'properties.contact_person', 'properties.user_id',
            'properties.cell', 'properties.agency_id')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');

        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            }
            //if user owns agencies{}

            if ($package->package_for != 'agency') {
                $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);
                $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
                return $listings;
            } else {
                //get agency from package agency table
                $package_agency_id = (new \App\Models\Package)->getAgencyFromPackageID($package->id);
                $listings = $listings->where('properties.agency_id', '=', $package_agency_id->agency_id);
                $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);
                return $listings;
            }

        }
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('package') && $request->has('property') && $request->has('duration')) {
                $duration = $request->input('duration');
                $package_id = $request->input('package');
                $property_id = $request->input('property');
                $package = (new \App\Models\Package)->getPackageFromId($package_id);
                if ($package) {
                    $remaining_days = Carbon::parse($package->activated_at)->diffInDays($package->expired_at);
                    $added_property = DB::table('package_properties')
                        ->select(DB::raw('Count(property_id) AS count'))
                        ->where('package_id', $package_id)
                        ->where('activated_at', '!=', null)->get()->pluck('count');

                    if ($added_property[0] < $package->property_count) {
                        if ($duration < $remaining_days) {
                            DB::table('package_properties')->updateOrInsert(['package_id' => $package_id, 'property_id' => $property_id], [
                                'duration' => $duration,
                                'activated_at' => Carbon::now()->toDateTimeString(),
                                'expired_at' => Carbon::now()->addDays($duration)->toDateTimeString(),
                            ]);
                            event(new AddPropertyInPackageEvent($property_id, $package));
//                        TODO:send an email to user as a record
                            return response()->json(['status' => 200, 'message' => 'Added']);
                        } else {
                            return response()->json(['status' => 201, 'message' => 'Duration is not allowed.']);
                        }
                    } else {
                        return response()->json(['status' => 201, 'message' => 'Property limit reached.']);
                    }

                }
            } else {
                return response()->json(['status' => 201, 'message' => 'Not found']);
            }
        } else {
            return response()->json(['status' => 201, 'message' => 'Not found']);
        }

    }

}
