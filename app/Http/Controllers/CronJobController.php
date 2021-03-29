<?php

namespace App\Http\Controllers;

use App\Events\NotifyUserPackageStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationOnPropertyUpdate;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Models\Property;
use App\Models\TempImage;
use App\Notifications\AddPropertiesInPackageNotification;
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
//                && $this->packageExpiry()
            ) {
                return response()->json(['data' => 'success', 'status' => 200]);
            } else {
                return response()->json(['data' => 'Error!', 'status' => 200]);
            }

        } else {
            return 'Not Found';
        }

    }

    private function packagePropertyExpired($package, $property_update)
    {
        $properties = (new Package)->getPropertiesFromPackageID($package->id);
        foreach ($properties as $property) {
            DB::table('properties')->where('id', $property)->update([$property_update => 0]);
            $data = (new \App\Models\Property)->select('purpose')->where('id', $property)->first();
            $listing_type = '';
            if ($package->packege_for == 'Gold')
                $listing_type = 'golden_listing';
            elseif (($package->packege_for == 'Silver'))
                $listing_type = 'silver_listing';

            if (DB::table('property_count_by_listings')
                ->where('property_purpose', $data->purpose)
                ->where('listing_type', $listing_type)
                ->where('property_count', '>', 0)->exists()) {
                DB::table('property_count_by_listings')
                    ->where('property_purpose', $data->purpose)
                    ->where('listing_type', $listing_type)
                    ->where('property_count', '>', 0)
                    ->decrement('property_count', 1);

            }


        }

    }

    private function packageExpiry()
    {
        $packages = Package::all();
        foreach ($packages as $package) {
            $agency_update = '';
            $property_update = '';
            if ($package->type == 'Gold') {
                $agency_update = 'featured_listing';
                $property_update = 'golden_listing';
            } elseif ($package->type == 'Silver') {
                $agency_update = 'key_listing';
                $property_update = 'silver_listing';
            }
            if ($package->status == 'active' && $package->expired_at != null && $package->expired_at < Carbon::now()) {
                $package->expired_at = Carbon::now()->toDateTimeString();
                $package->status = 'expired';
                $package->save();
                event(new NotifyUserPackageStatusChangeEvent($package));

                if ($package->package_for == 'agency') {
                    $agency = (new Package)->getAgencyFromPackageID($package->id);

                    DB::table('agencies')->where('id', $agency->agency_id)->update([$agency_update => 0]);
                    $this->packagePropertyExpired($package, $property_update);

                }
            } elseif ($package->status == 'active' && $package->expired_at != null && $package->expired_at >= Carbon::now()) {
                if (count((new Package)->getPropertiesFromPackageID($package->id)) == 0) {
                    $total_duration =Carbon::parse($package->activated_at)->diffInDays($package->expired_at);
                    $margin_time = ceil($total_duration / 2);
                    $difference = Carbon::parse($package->activated_at)->diffInDays(Carbon::now()->toDateTimeString());
                    $user = User::where('id', '=', $package->user_id)->first();

                    if ($difference <= $margin_time) {
                        $package->expired_at = Carbon::parse($package->expired_at)->addDays($difference);
                        $package->save();
                        //TODO :: send user notification
                        Notification::send($user, new AddPropertiesInPackageNotification($user, $package));
                    } else {
                        Notification::send($user, new AddPropertiesInPackageNotification($user, $package));
                    }
                }


                $properties = DB::table('package_properties')
                    ->select('property_id')
                    ->where('package_id', $package->id)
                    ->whereDate('expired_at', '<', Carbon::now()->toDateTimeString())->get()->toArray();
                foreach ($properties as $property_obj) {
                    $property = $property_obj->property_id;
                    DB::table('properties')->where('id', $property)->update([$property_update => 0]);
                    $data = Property::select('purpose')->where('id', $property)->first();
                    $listing_type = '';
                    if ($package->packege_for == 'Gold')
                        $listing_type = 'golden_listing';
                    elseif (($package->packege_for == 'Silver'))
                        $listing_type = 'silver_listing';

                    if (DB::table('property_count_by_listings')
                        ->where('property_purpose', $data->purpose)
                        ->where('listing_type', $listing_type)
                        ->where('property_count', '>', 0)->exists()) {
                        DB::table('property_count_by_listings')
                            ->where('property_purpose', $data->purpose)
                            ->where('listing_type', $listing_type)
                            ->where('property_count', '>', 0)
                            ->decrement('property_count', 1);
                    }
                }
            }
        }
        return true;
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


}
