<?php

namespace App\Http\Controllers\Package;

use App\Events\AddPropertyInPackageEvent;
use App\Events\NotifyAdminOfPackageRequestEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\Property;
use App\Notifications\PropertyAddedInPackage;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

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
            'price' => DB::table('package_costings')->select('type', 'price_per_unit', 'package_for')->where('package_for', '=', 'properties')->get(),
            'types' => PackagePrice::select('type')->distinct()->get()->pluck('type')->toArray(),
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
            $args = array();
            $args['duration'] = $request->duration;
            $args['type'] = $request->package;
            $args['count'] = $request->property_count;
            $args['for'] = $request->package_for;
            $amount = self::calculatePackagePrice($args);
            $args['amount'] = $amount['price'];


            $package = DB::table('packages')->insertGetId([
                'user_id' => Auth::guard('web')->user()->id,
                'type' => $request->input('package'),
                'package_for' => $request->has('package_for') ? $request->input('package_for') : 'properties',
                'property_count' => $request->input('property_count'),
                'duration' => $request->input('duration'),
                'package_cost' => $amount['price'],
                'status' => 'pending',
                'unit_cost' => $amount['unit_price'],
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
//            event(new NotifyAdminOfPackageRequestEvent($package));
            $args['pack-id'] = $package;

            return view('website.package.checkout.index', ['result' => $args]);
//                ->with('success', 'Request submitted successfully. You will be notified about the progress soon.');


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
        $result = $this->_listings($user, $package);
        $limit = 10;
        $page = (isset($request->page)) ? $request->page : 1;
        $last_id = ($page - 1) * $limit;
        $properties = $result[0]->where($condition)->orderBy($sort, $order);
        $properties = new Collection($properties->get());
        $properties = $properties->slice($last_id, $limit)->all();
        $paginatedSearchResults = new LengthAwarePaginator($properties, $result[1], $limit);
        return $paginatedSearchResults->setPath($request->url());


    }

    private function _listings(string $user, $package)
    {
        if ($package->package_for != 'agency') {
            $total_count = DB::table('property_count_by_user')
                ->select(DB::raw('sum(individual_count) as count'))
                ->where(['property_status' => 'active', 'user_id' => $user, 'listing_type' => 'basic_listing'])
                ->where('agency_id', '=', null)
                ->get()->pluck('count')[0];
//            dd($total_count);

            $listing = Property::select('properties.id', 'sub_type AS type', 'properties.purpose',
                'properties.status', 'locations.name AS location', 'cities.name as city', 'properties.views',
                'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by',
                'properties.silver_listing', 'properties.golden_listing',
                'price', 'properties.created_at AS listed_date', 'properties.created_at',
                'properties.contact_person', 'properties.user_id',
                'properties.cell', 'properties.agency_id')
                ->where('status', '=', 'active')
                ->where('properties.user_id', '=', $user)
                ->where('properties.agency_id', '=', null)
                ->whereNull('properties.deleted_at')
                ->join('locations', 'properties.location_id', '=', 'locations.id')
                ->join('cities', 'properties.city_id', '=', 'cities.id');

            return [$listing, $total_count];

        } else {
            //get agency from package agency table
            $package_agency_id = (new \App\Models\Package)->getAgencyFromPackageID($package->id);
            $total_count = DB::table('property_count_by_user')
                ->select(DB::raw('sum(agency_count) as count'))
                ->where('agency_id', $package_agency_id->agency_id)
                ->where(['property_status' => 'active', 'listing_type' => 'basic_listing'])->get()->pluck('count')[0];
            $listing = Property::select('properties.id', 'sub_type AS type', 'properties.purpose',
                'properties.status', 'locations.name AS location', 'cities.name as city', 'properties.views',
                'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by',
                'properties.silver_listing', 'properties.golden_listing',
                'price', 'properties.created_at AS listed_date', 'properties.created_at',
                'properties.contact_person', 'properties.user_id',
                'properties.cell', 'properties.agency_id')
                ->where('properties.agency_id', '=', $package_agency_id->agency_id)
                ->where('status', '=', 'active')
                ->whereNull('properties.deleted_at')
                ->join('locations', 'properties.location_id', '=', 'locations.id')
                ->join('cities', 'properties.city_id', '=', 'cities.id');

            return [$listing, $total_count];
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
                        if ($duration > 0 && $duration <= $remaining_days) {

                            $required_credit = ceil(intval(($package->unit_cost / 30) * intval($duration)));
                            if ((new \App\Models\UserWallet)->getCurrentCredit() < $required_credit) {
                                return response()->json(['status' => 201, 'message' => 'Insufficient Credit.']);
                            }

                            //calculate price unit_cost + days

                            $wallet = (new \App\Models\UserWallet)->getUserWallet(Auth::user()->getAuthIdentifier());

                            $wallet->current_credit = intval($wallet->current_credit) - $required_credit;
                            $wallet->save();


                            DB::Table('wallet_history')->insert([
                                'user_wallet_id' => $wallet->id,
                                'credit' => $wallet->current_credit
                            ]);

                            DB::table('package_properties')->updateOrInsert(['package_id' => $package_id, 'property_id' => $property_id], [
                                'duration' => $duration,
                                'activated_at' => Carbon::now()->toDateTimeString(),
                                'expired_at' => Carbon::now()->addDays($duration)->toDateTimeString(),
                            ]);
                            $selected_property = (new Property())->where('id', $property_id)->where('user_id', Auth::user()->getAuthIdentifier())->first();
                            if ($selected_property) {
                                if ($package->type == 'Gold')
                                    $selected_property->golden_listing = 1;
                                else if ($package->type == 'Platinum')
                                    $selected_property->platinum_listing = 1;
                                $selected_property->save();
                            }


                            $user = User::where('id', '=', $package->user_id)->first();
                            $user->notify(new PropertyAddedInPackage($property_id, $package));
                            event(new AddPropertyInPackageEvent($property_id, $package));


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

    public function packageAmount(Request $request)
    {
//        dd($request->all());
        if ($request->ajax()) {
            $args = array();
            $args['duration'] = $request->duration;
            $args['type'] = $request->type;
            $args['count'] = $request->count;
            $args['for'] = $request->for;
            return response()->json(['status' => 200, 'result' => self::calculatePackagePrice($args)]);
        } else {
            return response()->json(['status' => 201, 'message' => 'Not found']);
        }

    }

    public function calculatePackagePrice($args = array())
    {
        $unit_price = (new \App\Models\PackagePrice)->getAmount($args['type'], $args['for']);

        $price = $unit_price * $args['duration'];
        return ['unit_price' => $unit_price, 'price' => $price * $args['count']];

    }

    public function doCheckout(Request $request)
    {

        //here by pass the transaction action just store all info and activate package for now

        $data = $request->input();
        $id = $data['pack-id'];
        $product = DB::table('packages')->select('package_cost')->where('id', $id)->where('user_id', Auth::user()->id)->first();

        //1.
        //get formatted price. remove period(.) from the price
//        $temp_amount = $product[0]->price * 100;
//        $amount_array = explode('.', $temp_amount);


//        $pp_Amount = $product->package_cost;


        //2.
        //get the current date and time
        //be careful set TimeZone in config/app.php


        $DateTime = new \DateTime();
        $pp_TxnDateTime = $DateTime->format('YmdHis');

        //3.
        //to make expiry date and time add one hour to current date and time


        $ExpiryDateTime = $DateTime;
        $ExpiryDateTime->modify('+' . 1 . ' hours');
        $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');

        //4.
        //make unique transaction id using current date


        $pp_TxnRefNo = 'T' . $pp_TxnDateTime;

//        $post_data = array(
//            "pp_Version" => Config::get('constants.jazzcash.VERSION'),
//            "pp_TxnType" => "MWALLET",
//            "pp_Language" => Config::get('constants.jazzcash.LANGUAGE'),
//            "pp_MerchantID" => Config::get('constants.jazzcash.MERCHANT_ID'),
//            "pp_SubMerchantID" => "",
//            "pp_Password" => Config::get('constants.jazzcash.PASSWORD'),
//            "pp_BankID" => "TBANK",
//            "pp_ProductID" => "RETL",
//            "pp_TxnRefNo" => $pp_TxnRefNo,
//            "pp_Amount" => $pp_Amount,
//            "pp_TxnCurrency" => Config::get('constants.jazzcash.CURRENCY_CODE'),
//            "pp_TxnDateTime" => $pp_TxnDateTime,
//            "pp_BillReference" => "billRef",
//            "pp_Description" => "Description of transaction",
//            "pp_TxnExpiryDateTime" => $pp_TxnExpiryDateTime,
//            "pp_ReturnURL" => Config::get('constants.jazzcash.RETURN_URL'),
//            "pp_SecureHash" => "",
//            "ppmpf_1" => "1",
//            "ppmpf_2" => "2",
//            "ppmpf_3" => "3",
//            "ppmpf_4" => "4",
//            "ppmpf_5" => "5",
//        );

//        $pp_SecureHash = $this->get_SecureHash($post_data);
//
//        $post_data['pp_SecureHash'] = $pp_SecureHash;
//
//        $values = array(
//            'package_id' => $id,
//            'TxnRefNo' => $post_data['pp_TxnRefNo'],
//            'amount' => $pp_Amount,
//            'status' => 'pending'
//        );
//        DB::table('package_transactions')->insert($values);

//        Session::put('post_data', $post_data);
//        return view('website.package.checkout.do-checkout');


        //Remove following code after implementation of gateways


//        if ($product) {
//            DB::table('packages')
//                ->where('id', $package->package_id)
//                ->update(['status' => 'active']);

//            $product->status = 'active';
//            $product->save();
//
//
//        }

        event(new NotifyAdminOfPackageRequestEvent($product));

//        return view('website.package.buy-package', [
//            'price' => DB::table('package_costings')->select('type', 'price_per_unit', 'package_for')->where('package_for', '=', 'properties')->get(),
//            'types' => PackagePrice::select('type')->distinct()->get()->pluck('type')->toArray(),
//            'user_agencies' => Auth::guard('web')->user()->agencies->where('status', 'verified'),
//            'recent_properties' => (new FooterController)->footerContent()[0],
//            'footer_agencies' => (new FooterController)->footerContent()[1],
//        ])->with('success', 'Request submitted successfully. You will be notified about the progress soon.');

        return redirect()->route('package.index')->with('success', 'Request submitted successfully. You will be notified about the progress soon.');


    }

    private function get_SecureHash($data_array)
    {
        ksort($data_array);

        $str = '';
        foreach ($data_array as $key => $value) {
            if (!empty($value)) {
                $str = $str . '&' . $value;
            }
        }

        $str = Config::get('constants.jazzcash.INTEGERITY_SALT') . $str;

        $pp_SecureHash = hash_hmac('sha256', $str, Config::get('constants.jazzcash.INTEGERITY_SALT'));
        //echo '<pre>';
        //print_r($data_array);
        //echo '</pre>';

        return $pp_SecureHash;
    }

//function to accept api call from bank
    public function paymentStatus(Request $request)
    {
        $response = $request->input();
        dd($response);
//        echo '<pre>';
//        print_r($response);
//        echo '</pre>';

        if ($response['pp_ResponseCode'] == '000') {
            $response['pp_ResponseMessage'] = 'Your Payment has been Successful';
            $values = array('status' => 'completed');

            DB::table('package_transactions')
                ->where('TxnRefNo', $response['pp_TxnRefNo'])
                ->update(['status' => 'completed']);

            $package = DB::table('package_transactions')
                ->where('TxnRefNo', $response['pp_TxnRefNo'])
                ->select('package_id')->first();
            if ($package) {
                DB::table('packages')
                    ->where('id', $package->package_id)
                    ->update(['status' => 'active']);


            }

        }

        return view('website.package.checkout.payment-status', ['response' => $response]);
    }


}
