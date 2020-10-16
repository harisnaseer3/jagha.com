<?php

use App\Http\Controllers\CountTableController;
use App\Http\Controllers\Dashboard\LocationController;
use App\Http\Controllers\FloorPlanController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VideoController;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Image;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        TODO: add value for expiry of property
//        to get all files of directory
        $path = ('database/json');

        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file !== '.' && $file !== '..') {
                        if ($dh_2 = opendir('database/json/' . $file)) {
                            while (($file_2 = readdir($dh_2)) !== false) {
                                if ($file_2 !== '.' && $file_2 !== '..') {
//                                    foreach ($files as $jsonfile) {
                                    $strJsonFileContents = File::get('database/json/' . $file . '/' . $file_2);
                                    $array = json_decode($strJsonFileContents, true);

                                    foreach ($array as $data) {
                                        try {
                                            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $data['city']))->first();
                                            $location = $this->storeLocation($data['location'], $city);

                                            $user_id = 1;
                                            $json_features = '';

                                            if (!empty($data['features'])) {
                                                $json_features = [
                                                    'features' => $data['features']['features'],
                                                    'icons' => $data['features']['icons']
                                                ];
                                            }
                                            $clean_location = str_replace('-', '', $location['location_name']);
                                            $address = $prepAddr = str_replace(' ', '+', $clean_location . ',' . $city->name . ' Pakistan');
                                            $apiKey = config('app.google_map_api_key');
                                            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey);
                                            $geo = json_decode($geo, true); // Convert the JSON to an array
                                            $latitude = '';
                                            $longitude = '';
//                                            dd($geo);
//                                            dd('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey);
//                                            dd($address);

                                            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                                                $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                                                $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
                                            }
//                                            dd($geo);
                                            $type = '';

                                            $home = ['House', 'Flat', 'Upper Portion', 'Lower Portion', 'Farm House', 'Room', 'Penthouse'];
                                            $plot = ['Residential Plot', 'Commercial Plot', 'Agricultural Land', 'Industrial Land', 'Plot File', 'Plot Form'];
                                            $commercials = ['Office', 'Shop', 'Warehouse', 'Factory', 'Building', 'Other'];

                                            $subtype = $data['type'];
                                            if (in_array($subtype, $home)) $type = 'Homes';
                                            if (in_array($subtype, $plot)) $type = 'Plots';
                                            if (in_array($subtype, $commercials)) $type = 'Commercial';

                                            $max_id = DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'property_management' AND TABLE_NAME = 'properties'")[0]->AUTO_INCREMENT;

                                            $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
                                            $agency = '';
                                            if (isset($data['agency_name']) && $data['agency_name'] !== '') {
                                                if (Agency::where('city_id', '=', $city->id)->where('title', '=', $data['agency_name'])->exists()) {
                                                    $agency = (new App\Models\Agency)
                                                        ->where('city_id', '=', $city->id)
                                                        ->where('title', '=', $data['agency_name'])->first();
                                                    (new App\Models\Agency)->where('city_id', '=', $city->id)->where('title', '=', $data['agency_name'])
                                                        ->update([
                                                            'description' => $data['agency_description'],
                                                            'phone' => null,
                                                            'cell' => isset($data['agency_phone']) ? $data['agency_phone'] : null,
                                                            'fax' => null,
                                                            'address' => null,
                                                            'zip_code' => null,
                                                            'country' => 'Pakistan',
                                                            'email' => null,
                                                            'website' => null,
                                                            'ceo_name' => isset($data['agency_agent']) ? $data['agency_agent'] : null,
                                                            'ceo_designation' => null,
                                                            'ceo_message' => null,
                                                            'status' => 'verified',
                                                            'reviewed_by' => null
                                                        ]);
//                                                    TODO: add
                                                    if (isset($data['agency_logo']) && $data['agency_logo'] !== '')
                                                        $this->storeAgencyLogo($data['agency_logo'], $agency);

                                                } else {
                                                    $agency = (new App\Models\Agency)->Create(
                                                        [
                                                            'user_id' => 1,
                                                            'city_id' => $city->id,
                                                            'title' => $data['agency_name'],
                                                            'description' => $data['agency_description'],
                                                            'phone' => null,
                                                            'cell' => isset($data['agency_phone']) ? $data['agency_phone'] : null,
                                                            'fax' => null,
                                                            'address' => null,
                                                            'zip_code' => null,
                                                            'country' => 'Pakistan',
                                                            'email' => null,
                                                            'website' => null,
                                                            'ceo_name' => isset($data['agency_agent']) ? $data['agency_agent'] : null,
                                                            'ceo_designation' => null,
                                                            'ceo_message' => null,
                                                            'status' => 'verified',
                                                            'reviewed_by' => null

                                                        ]);
                                                    DB::table('agency_cities')->insert(['agency_id' => $agency->id, 'city_id' => $city->id]);
                                                    DB::table('agency_users')->insert(['agency_id' => $agency->id, 'user_id' => 1]);

                                                    if (isset($data['agency_logo']) && $data['agency_logo'] !== '')
                                                        $this->storeAgencyLogo($data['agency_logo'], $agency);
                                                }
                                            }
                                            $area_values = $this->calculateArea($data['area_unit'], number_format((float)str_replace(',', '', $data['area']), 2, '.', ''));
                                            $property = (new Property)->Create([
                                                'reference' => $reference,
                                                'user_id' => $user_id,
                                                'city_id' => $city->id,
                                                'location_id' => $location['location_id'],
                                                'agency_id' => $agency == '' ? null : $agency->id,
                                                'purpose' => $data['purpose'],
                                                'sub_purpose' => null,
                                                'type' => $type,
                                                'sub_type' => $subtype,
                                                'title' => $data['title'],
                                                'description' => $data['description'],
                                                'price' => $data['price'],
                                                'land_area' => number_format((float)str_replace(',', '', $data['area']), 2, '.', ''),
                                                'area_unit' => $data['area_unit'],
                                                'area_in_sqft' => $area_values['sqft'],
                                                'area_in_sqyd' => $area_values['sqyd'],
                                                'area_in_sqm' => $area_values['sqm'],
                                                'area_in_marla' => $area_values['marla'],
                                                'area_in_new_marla' => $area_values['new_marla'],
                                                'area_in_kanal' => $area_values['kanal'],
                                                'area_in_new_kanal' => $area_values['new_kanal'],
                                                'bedrooms' => isset($data['bedrooms']) && $data['bedrooms'] != 'Added' && $data['bedrooms'] != '-' ? $data['bedrooms'] : 0,
                                                'bathrooms' => isset($data['bathrooms']) && $data['bathrooms'] != '-' && $data['bathrooms'] != 'Added' ? $data['bathrooms'] : 0,
                                                'latitude' => $latitude,
                                                'longitude' => $longitude,
                                                'features' => json_encode($json_features),
                                                'status' => 'active',
                                                'basic_listing' => 1,
                                                'contact_person' => isset($data['agency_agent']) ? $data['agency_agent'] : null,
                                                'phone' => null,
                                                'cell' => isset($data['agency_phone']) ? $data['agency_phone'] : null,
                                                'fax' => null,
                                                'email' => null,
                                            ]);

                                            if ($data['images']) {
                                                $this->storeImages($data['images'], $property);
                                            }
                                            // insertion in count tables when property status is active
                                            (new CountTableController)->_insertion_in_count_tables($city, $location, $property);
                                            $dt = Carbon::now();
                                            $property->activated_at = $dt;

                                            $expiry = $dt->addMonths(3)->toDateTimeString();
                                            $property->expired_at = $expiry;
                                            $property->save();

                                        } catch (Exception $e) {
                                            dd($e);
                                        }
                                        print('success, ' . $data['url'] . PHP_EOL);
                                    }
                                    print('successfully read file ' . $file_2 . PHP_EOL);
                                }
                            }
                        }
                        print('successfully read folder ' . $file . PHP_EOL);
//                        print('Cut and paste this folder to dumped json files folder and copy images from drive to images folder ' . $file.PHP_EOL);
//                        exit();
                    }
                }
            }
            closedir($dh);
        }
    }

    public function calculateArea($area_unit, $land_area)
    {
        $area = number_format($land_area, 2, '.', '');
        $area_in_sqft = 0;
        $area_in_sqyd = 0;
        $area_in_sqm = 0;
        $area_in_marla = 0;
        $area_in_new_marla = 0;
        $area_in_kanal = 0;
        $area_in_new_kanal = 0;

        if ($area_unit === 'Marla') {
            $area_in_sqft = $area * 225;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 4500;
            $area_in_new_kanal = $area_in_sqft / 3600;
        }
        if ($area_unit === 'Square Feet') {
            $area_in_sqft = $area;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 4500;
            $area_in_new_kanal = $area_in_sqft / 3600;
        }
        if ($area_unit === 'Square Meters') {
            $area_in_sqft = $area * 10.7639;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 4500;
            $area_in_new_kanal = $area_in_sqft / 3600;
        }
        if ($area_unit === 'Square Yards') {
            $area_in_sqft = $area * 9;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area_in_sqft / 4500;
            $area_in_new_kanal = $area_in_sqft / 3600;
        }
        if ($area_unit === 'Kanal') {
            $area_in_sqft = $area * 4500;
            $area_in_marla = $area_in_sqft / 272;
            $area_in_new_marla = $area_in_sqft / 225;
            $area_in_sqyd = $area_in_sqft / 9;
            $area_in_sqm = $area_in_sqft / 10.7639;
            $area_in_kanal = $area;
            $area_in_new_kanal = $area_in_sqft / 3600;
        }
        return [
            'new_marla' => $area_in_new_marla,
            'sqft' => $area_in_sqft,
            'sqyd' => $area_in_sqyd,
            'sqm' => $area_in_sqm,
            'marla' => $area_in_marla,
            'kanal' => $area_in_kanal,
            'new_kanal' => $area_in_new_kanal];

    }

    public function storeLocation($location_name, $city)
    {
//        for seeding purpose here user id consider 1
        $user_id = 1;
        if ($location_name == '') {
            $location_name = $city->name;
        }


        try {
            $location = (new Location)->updateOrCreate(['name' => $location_name, 'city_id' => $city->id], [
                'user_id' => $user_id,
                'city_id' => $city->id,
                'name' => $location_name,
            ]);
            return ['location_id' => $location->id, 'location_name' => $location->name];
        } catch (Exception $e) {
            dd($e);
//            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    public function storeAgencyLogo($logo, $agency)
    {
        $filename = rand(0, 99);
        $extension = 'webp';
        $filenamewithoutext = 'logo-' . $filename . time();
        $filenametostoreindb = $filenamewithoutext . '.' . $extension;
//        $filenametostore = 'logo-'.$filename. time() . '-200x200.' . $extension;

        $files = [['width' => 100, 'height' => 100], ['width' => 450, 'height' => 350]];
        foreach ($files as $file) {
            $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;

            Storage::put('public/agency_logos/' . $updated_path, fopen("database/images/" . $logo, 'r+'));
            $thumbnailpath = ('thumbnails/agency_logos/' . $updated_path);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 1);
            $img->save($thumbnailpath);

            $agency->logo = $filenametostoreindb;
            $agency->save();
        }
    }

    public function storeImages($images, $property)
    {
        foreach ($images as $file_name) {

            $filename = rand(0, 99);
            $extension = 'webp';

            //filename to store
            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [['width' => 750, 'height' => 600], ['width' => 450, 'height' => 350], ['width' => 200, 'height' => 200]];
//            $files = [$filenamewithoutext . '-750x600.' . $extension, $filenamewithoutext . '-450x350.' . $extension, $filenamewithoutext . '-200X200.' . $extension];

            foreach ($files as $file) {
                $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;
                Storage::put('public/properties/' . $updated_path, fopen("database/images/" . $file_name, 'r+'));

                //Resize image here
                $thumbnailpath = ('thumbnails/properties/' . $updated_path);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);
            }
            $user_id = 1;

            (new Image)->updateOrCreate(['property_id' => $property->id, 'name' => $filenametostore], [
                'user_id' => $user_id,
                'property_id' => $property->id,
                'name' => $filenametostore
            ]);
        }
    }

}
