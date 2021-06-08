<?php

namespace App\Http\Controllers;

use App\Events\NotifyUserPackageStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Package\PackageLogController;
use App\Http\Controllers\Wallet\WalletController;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Models\Property;
use App\Models\TempImage;
use App\Models\UserWallet;
use App\Notifications\AddPropertiesInPackageNotification;
use App\Notifications\PackageExpiryMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CronJobController extends Controller
{
    function executeTasks(Request $request)
    {
        if ($request->ajax()) {

            if (
//                $this->updatePropertyStatus() &&
                $this->HourlyUpdate()
                &&
                $this->packageExpiry()
            ) {
                return response()->json(['data' => 'success', 'status' => 200]);
            } else {
                return response()->json(['data' => 'Error!', 'status' => 200]);
            }

        } else {
            return 'Not Found';
        }

    }

    private function packageExpiry()
    {
        $packages = Package::all();

        foreach ($packages as $package) {
            $agency_update = '';
            $property_update = '';

            if ($package->type == 'Platinum') {
                $agency_update = 'featured_listing';
                $property_update = 'platinum_listing';
            } elseif ($package->type == 'Gold') {
                $agency_update = 'key_listing';
                $property_update = 'golden_listing';
            }
            $user = User::where('id', '=', $package->user_id)->first();
            $credit = (new UserWallet())->getCurrentCredit($user->id);
            if ($package->status == 'active' && $package->expired_at != null && $package->expired_at <= Carbon::now()->toDateTimeString()) {


                if (count((new Package)->getPropertiesFromPackageID($package->id)) == 0 && $credit > 0) {

                    //if no property is added in package and credit is greater than 0
                    $deduction_amount = ceil(intval($package->package_cost / 2));
                    if ($credit >= $deduction_amount) {
                        //from package get total_cost/2

                        //TODO: deduct half credit form wallet if no property is added in package + mail that new duration add and now add properties in package
                        $total_duration = Carbon::parse($package->activated_at)->diffInDays($package->expired_at);
                        $margin_time = ceil($total_duration / 2);
//                        $margin_time = ceil((intval($package->duration) * 30)  / 2);

//                        dd($margin_time);

                        $package->expired_at = Carbon::parse($package->expired_at)->addDays($margin_time)->toDateTimeString();
                        $package->save();


                        $this->withdrawCredit($package->user_id, $deduction_amount);


                        //tell user your package expiry is extended and half balance is deducted
                        Notification::send($user, new PackageExpiryMail($user, $package, 2));
                        continue;
                    }


                } else {

                    //from package get total_cost/2  deduct all amount from wallet
                    $package->expired_at = Carbon::now()->toDateTimeString();
                    $package->status = 'expired';
                    $package->save();

                    $log_pack = array(
                        'package_id' => $package->id,
                        'status' => 'expired',
                        'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier()
                    );

                    (new PackageLogController)->add($log_pack);

//                    event(new NotifyUserPackageStatusChangeEvent($package));

                    if ($package->package_for == 'agency') {
                        $agency = (new Package)->getAgencyFromPackageID($package->id);
                        DB::table('agencies')->where('id', $agency->agency_id)->update([$agency_update => 0]);
                    }

                    $this->packagePropertyExpired($package, $property_update);
                    Notification::send($user, new PackageExpiryMail($user, $package, 1));
                    continue;
                }


            } else if ($package->status == 'active' && $package->expired_at != null && Carbon::parse($package->expired_at)->format('d-m-Y') == Carbon::now()->addDays(7)->format('d-m-Y')) {
                Notification::send($user, new PackageExpiryMail($user, $package, 3));

                continue;
            } else {

                continue;
            }
        }

        return true;

    }

    private function packagePropertyExpired($package, $property_update)
    {
        $properties = (new Package)->getPropertiesFromPackageID($package->id);
        if (count($properties) > 0) {
            foreach ($properties as $property) {
                DB::table('properties')->where('id', $property)->update([$property_update => 0]);
//            $data = (new \App\Models\Property)->select('purpose')->where('id', $property)->first();
//            $listing_type = '';
//            if ($package->package_for == 'Platinum')
//                $listing_type = 'platinum_listing';
//            elseif (($package->package_for == 'Gold'))
//                $listing_type = 'gold_listing';

//            if (DB::table('property_count_by_listings')
//                ->where('property_purpose', $data->purpose)
//                ->where('listing_type', $listing_type)
//                ->where('property_count', '>', 0)->exists()) {
//                DB::table('property_count_by_listings')
//                    ->where('property_purpose', $data->purpose)
//                    ->where('listing_type', $listing_type)
//                    ->where('property_count', '>', 0)
//                    ->decrement('property_count', 1);
//
//            }


            }
        }


    }


    private function packageLog($package)
    {
        DB::table('package_logs')->insert([
            'package_id' => $package->id,
            'admin_id' => Auth::guard('admin')->user()->getAuthIdentifier(),
            'admin_name' => Auth::guard('admin')->user()->name,
            'status' => $package->status,
            'rejection_reason' => $package->rejection_reason,
        ]);
    }

    private function updatePropertyStatus()
    {
        //add  query to compare today's and expiry date of property
        $columns = (new Property)->where('status', '=', 'active')->whereDate('expired_at', '<=', Carbon::now()->toDateTimeString())->limit(50)->get();
        foreach ($columns as $column) {
            (new CountTableController())->_delete_in_status_purpose_table($column, $column->status);
            $city = (new City)->select('id', 'name')->where('id', '=', $column->city_id)->first();
            $location = (new Location)->select('id', 'name')->where('id', '=', $column->location_id)->first();

            $column->update([
                'status' => 'expired',
                'activated_at' => null,
                'expired_at' => date('Y-m-d H:i:s'),
            ]);
            (new CountTableController())->_on_deletion_insertion_in_count_tables($city, $location, $column);
            (new CountTableController)->_insert_in_status_purpose_table($column);
            $this->dispatch(new SendNotificationOnPropertyUpdate($column));
            if (Auth::guard('admin')->user()) {
                (new PropertyLogController())->store($column);
            }
        }

        return true;
    }

    private function HourlyUpdate()
    {
        TempImage::where('expiry_time', '<=', Carbon::now()->toDateTimeString())->forceDelete();

        $data = DB::table('temp_users')->select('user_id')->where('expire_at', '<=', Carbon::now()->toDateTimeString());
        $user_delete = $data->get()->toArray();
        if (!empty($user_delete)) {
            foreach ($user_delete as $val) {
                User::where('id', $val->user_id)->where('email_verified_at', null)->forceDelete();
            }

        }
        $data->delete();
        return true;
    }

    public function withdrawCredit($user_id, $amount)
    {
        $credit_id = 0;

        $user_wallet = (new \App\Models\UserWallet)->getUserWallet($user_id);
        if ($user_wallet) {
            $user_wallet->current_credit = intval($user_wallet->current_credit) - $amount;
            $user_wallet->save();
            $credit_id = $user_wallet->id;
        }

        DB::Table('wallet_history')->insert([
            'user_wallet_id' => $credit_id,
            'credit' => $amount
        ]);
    }
}
