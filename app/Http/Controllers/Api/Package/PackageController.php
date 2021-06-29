<?php

namespace App\Http\Controllers\Api\Package;

use App\Events\NotifyAdminOfPackageRequestEvent;
use App\Events\NotifyUserPackageStatusChangeEvent;
use App\Http\Controllers\Package\PackageLogController;
use App\Http\Controllers\Wallet\WalletController;
use App\Models\Agency;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Notifications\PackageStatusChange;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    //function to accept api call from bank
    public function paymentStatus(Request $request)
    {
        $response = $request->input();
        Session::put('response', $response);
        if ($response['pp_ResponseCode'] == '000') {
            $response['pp_ResponseMessage'] = 'Your Payment has been Successful';
            $values = array('status' => 'completed');
//
            DB::table('package_transactions')
                ->where('TxnRefNo', $response['pp_TxnRefNo'])
                ->update(['status' => 'completed']);
//
            $package_id = DB::table('package_transactions')
                ->where('TxnRefNo', $response['pp_TxnRefNo'])
                ->select('package_id')->first();

            $package = (new \App\Models\Package)->getPackageFromId($package_id->package_id);

            if ($package) {
                DB::table('packages')
                    ->where('id', $package->id)
                    ->update(
                        [
                            'status' => 'active',
                            'activated_at' => Carbon::now()->toDateTimeString(),
                            'expired_at' => Carbon::now()->addMonths($package->duration)->toDateTimeString()
                        ]);


                $agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id);
                if ($agency) {
                    if ($package->type == 'Gold') {
                        DB::table('agencies')
                            ->where('id', '=', $agency->agency_id)
                            ->update([
                                'key_listing' => 1
                            ]);
                    } else if ($package->type == 'Platinum') {
                        DB::table('agencies')
                            ->where('id', '=', $agency->agency_id)
                            ->update(['featured_listing' => 1]);
                    }
                }


                (new WalletController())->addCredit($package->user_id, $package->package_cost);

                $log_pack = array(
                    'package_id' => $package->id,
                    'status' => 'active',
                    'user_id' => $package->user_id
                );

                (new PackageLogController)->add($log_pack);

                $user = User::where('id', '=', $package->user_id)->first();

                event(new NotifyAdminOfPackageRequestEvent($package->id));

                $user->notify(new PackageStatusChange($package));
                event(new NotifyUserPackageStatusChangeEvent($package));


            }
        }
        return view('website.package.checkout.payment-status');
    }
}
