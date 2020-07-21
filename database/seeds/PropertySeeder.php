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
//        to get all files of directory
        $path = ('C:/inetpub/wwwroot/property/database/json');
        $files = File::files($path);
//        dd($path, $files);
        foreach ($files as $jsonfile)
        {
        $strJsonFileContents = File::get($jsonfile);
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

                $address = $prepAddr = str_replace(' ', '+', $location['location_name'] . ',' . $city->name . ' Pakistan');
                $apiKey = config('app.google_map_api_key');
                $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey);
                $geo = json_decode($geo, true); // Convert the JSON to an array
                $latitude = '';
                $longitude = '';

                if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                    $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                    $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
                }

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
                if (isset($data['agency_logo']) && $data['agency_logo'] !== '') {
                    $agency = (new App\Models\Agency)->updateOrCreate(['title' => $data['agency_name'], 'phone' => $data['agency_phone']], [
                        'user_id' => 1,
                        'city' => json_encode([$city->name]),
                        'title' => $data['agency_name'],
                        'description' => $data['agency_description'],
                        'phone' => isset($data['agency_phone']) ? explode('-',$data['agency_phone'])[0]:null,
                        'cell' => null,
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
                    ]);
                    $this->storeAgencyLogo($data['agency_logo'], $agency);

                }
                $property = (new Property)->Create([
                    'reference' => $reference,
                    'user_id' => $user_id,
                    'city_id' => $city->id,
                    'location_id' => $location['location_id'],
                    'agency_id' => $agency === '' ? null : $agency->id,
                    'purpose' => $data['purpose'],
                    'sub_purpose' => null,
                    'type' => $type,
                    'sub_type' => $subtype,
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'land_area' => number_format((float)str_replace(',','',$data['area']), 2,'.', ''),
                    'area_unit' => $data['area_unit'],
                    'bedrooms' => isset($data['bedrooms']) && $data['bedrooms'] != 'Added'  && $data['bedrooms']!='-'  ? $data['bedrooms'] : 0,
                    'bathrooms' => isset($data['bathrooms']) && $data['bathrooms'] != '-' && $data['bathrooms'] != '-' ? $data['bathrooms'] : 0,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'features' => json_encode($json_features),
                    'status' => 'active',
//                    TODO: remove nullable after fetching agency user
                    'contact_person' => isset($data['agency_agent']) ? $data['agency_agent'] : null,
                    'phone' => null,
                    'cell' => isset($data['agency_phone']) ? explode('-',$data['agency_phone'])[0] : null,
                    'fax' => null,
                    'email' => null,
                ]);

                if ($data['images']) {
                    $this->storeImages($data['images'], $property);
                }
                // insertion in count tables when property status is active
                (new CountTableController)->_insertion_in_count_tables($city, $location, $property);

            } catch (Exception $e) {
                dd($e);
            }
            print(', success, '. $data['url']);
        }
//        factory(Property::class, 10000)->create();
        }
    }

    public function storeLocation($location_name, $city)
    {
//        for seeding purpose here user id consider 1
        $user_id = 1;
        try {
            $location = (new Location)->updateOrCreate(['name' => $location_name, 'city_id' => $city->id], [
                'user_id' => $user_id,
                'city_id' => $city->id,
                'name' => $location_name,
            ]);
            return ['location_id' => $location->id, 'location_name' => $location->name];
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Record not added, try again.');
        }
    }

    public function storeAgencyLogo($logo, $agency)
    {
        $filename = rand(0, 99);
        $extension = 'webp';
        $filenametostore = 'logo-'.$filename. time() . '-200x200.' . $extension;
//        Storage::disk('public')->put( $request->file('photo')->hashName(), $photo);
        Storage::put('public/agency_logos/' . $filenametostore, fopen("database/images/" . $logo, 'r+'));


        $thumbnailpath =('thumbnails/agency_logos/' . $filenametostore);

        $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 1);
        $img->save($thumbnailpath);

        $agency->logo = $filenametostore;
        $agency->save();
    }

    public function storeImages($images, $property)
    {
        foreach ($images as $file_name) {

            $filename = rand(0, 99);
            $extension = 'webp';

            //filename to store
            $filenamewithoutext = $filename . time();
            $filenametostore = $filenamewithoutext . '.' . $extension;
            $files = [$filenamewithoutext.'-750x600.'.$extension, $filenamewithoutext.'-450x350.'.$extension, $filenamewithoutext.'-200X200.'.$extension];

            foreach ($files as $file){
                Storage::put('public/properties/' . $file, fopen("database/images/" . $file_name, 'r+'));

                //Resize image here
                $thumbnailpath =('thumbnails/properties/' . $file);

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit(750, 600, function ($constraint) {
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
