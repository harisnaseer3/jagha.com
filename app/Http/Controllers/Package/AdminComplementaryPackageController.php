<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Wallet\WalletController;
use App\Jobs\ComplementaryPackageActivation;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminComplementaryPackageController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//    }

    public function index()
    {
        return view('website.admin-pages.package.complementary-package');
    }

    public function getUserDetails(Request $request)
    {
//        dd($request->all());
        if ($request->ajax()) {
            if (isset($request->email)) {
                $user_data = User::getUserByEmail($request->email);

                $types = PackagePrice::select('type')->distinct()->get()->pluck('type')->toArray();

                $agencies = [];
                $user = [];
                if ($user_data) {
                    $user = ['name' => $user_data->name, 'email' => $user_data->email, 'id' => $user_data->id];
                    $agencies = Agency::select('id', 'title')->where('user_id', $user_data->id)->pluck('id', 'title')->toArray();
                    $data['status'] = '200';
                    $data['view'] = View('website.admin-pages.components.complementary-package',
                        ['user' => $user,
                            'agencies' => $agencies,
                            'types' => $types
                        ])->render();

                    return $data;

                } else {
                    $data['status'] = '201';
                    return $data;
                }
            } else {
                $data['status'] = '201';
                return $data;
            }

        } else {
            return 'not found';
        }
    }


    public function store(Request $request)
    {
//        dd($request->all());

        $validator = Validator::make($request->all(), Package::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again 1.');
        }
        try {
            $args = array();
            $args['duration'] = $request->duration;
            $args['type'] = $request->package;
            $args['count'] = $request->property_count;
            $args['for'] = $request->package_for;
            $amount = (new PackageController())->calculatePackagePrice($args);
            $args['amount'] = $amount['price'];


            $package = DB::table('packages')->insertGetId([
                'user_id' => $request->user_id,
                'type' => $request->input('package'),
                'package_for' => $request->has('package_for') ? $request->input('package_for') : 'properties',
                'property_count' => $request->input('property_count'),
                'duration' => $request->input('duration'),
                'package_cost' => $amount['price'],
                'status' => $request->has('status') ? $request->input('status') : 'pending',
                'unit_cost' => $amount['unit_price'],
                'is_complementary' => $request->has('is_complementary') ? 1 : 0,
                'activated_at' => Carbon::now()->toDateTimeString(),
                'expired_at' => Carbon::now()->addMonths($request->input('duration'))->toDateTimeString()
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
            DB::table('package_logs')->insert([
                'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier(),
                'package_id' => $package,
                'admin_name' => Auth::guard('admin')->user()->name,
                'status' => $request->has('status') ? $request->input('status') : 'pending'

            ]);
//            $credit_id = 0;

            (new WalletController())->addCredit($request->user_id, $amount['price']);
//            $user_wallet = (new \App\Models\UserWallet)->getUserWallet($request->user_id);
//            if ($user_wallet) {
//                $user_wallet->current_credit = intval($user_wallet->current_credit) + $amount['price'];
//                $user_wallet->save();
//                $credit_id = $user_wallet->id;
//            } else {
//                $credit_id = DB::Table('User_wallet')->insertGetId([
//                    'user_id' => $request->user_id,
//                    'current_credit' => $amount['price'],
//                ]);
//            }
//
//            DB::Table('wallet_history')->insert([
//                'user_wallet_id' => $credit_id,
//                'debit' => $amount['price']
//            ]);


            //notify user on package complementary allotment

            $this->dispatch(new ComplementaryPackageActivation($request->user_id, $package));
            return redirect()->back()->with('success', 'Package Assigned Successfully.');

        } catch (\Exception $e) {
//            dd($e->getMessage());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error storing record, try again 2.');
        }
    }


}
