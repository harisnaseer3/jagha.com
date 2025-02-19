<?php

namespace App\Http\Controllers;

use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

ini_set('display_errors', 1);
error_reporting(E_ALL);
class JsonUploadController extends Controller
{
    public function showForm()
    {
        return view('upload-json');
    }

    public function checkRole()
    {
//        dd(auth()->user()->roles()->first()->name);
        if (auth()->check()) {
            $roles = auth()->user()->hasRole('Investor');
            dd($roles);
        } else {
            dd('No user is logged in.');
        }

    }
    public function processUpload(Request $request)
    {
        // Retrieve and decode the JSON file
        $file = $request->file('json_file');
        $jsonData = json_decode(file_get_contents($file), true);

        if (!isset($jsonData['hits'])) {
            return back()->withErrors(['Invalid JSON file format']);
        }

        try {
            DB::beginTransaction();

            foreach ($jsonData['hits'] as $data) {
                // Transform the data for the `properties` table
                $areaInSqm = $data['area'];
                $locationId = null;
                $agencyId = null;

                $getCityId = isset($data['location'][2]['name']) ? $data['location'][2]['name'] : null;
                $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $getCityId))->first();

                // Insert related location data into `locations` table
                if (isset($data['_geoloc'])) {
                    $locationId = DB::table('locations')->insertGetId([
                        'user_id' => 1,
                        'city_id' => 1,
                        'name' => isset($data['location'][3]['name']) ? $data['location'][3]['name'] : null,
                        'latitude' => $data['_geoloc']['lat'] ?? null,
                        'longitude' => $data['_geoloc']['lng'] ?? null,
                    ]);
                }
//
//                // Transform and insert data for the `agencies` table
                if (isset($data['agency'])) {
                    $agencyId = DB::table('agencies')->insertGetId([
                        'user_id' => 1,
                        'city_id' => $city->id,
                        'title' => $data['agency']['name'] ?? null,
                        'description' => $data['agency']['name_l1'] ?? null,
                        'country' => 'Pakistan',
                    ]);
                    DB::table('property_count_by_agencies')->insertGetId([
                        'agency_id' => $agencyId,
                        'property_status' => 'active',
                        'listing_type' => 'basic_listing',
                    ]);
                }

                $max_id = 0;
                $max_id = DB::table('properties')->select('id')->orderBy('id', 'desc')->first()->id;
                $max_id = $max_id + 1;
                $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);

                    // Prepare property data
                $propertyData = [
                    'user_id' => 1,
                    'reference' => $reference ?? null,
                    'city_id' => $city->id,
                    'location_id' => $locationId,
                    'agency_id' => $agencyId,
                    'purpose' => $data['purpose'] === 'for-sale' ? 'Sale' : $data['purpose'],
                    'type' => isset($data['category'][0]['name']) ? $data['category'][0]['name'] : null,
                    'sub_type' => isset($data['category'][1]['name']) ?
                        (strtolower($data['category'][1]['name']) === 'houses' ? 'House' : $data['category'][1]['name'])
                        : null,
//                    'title' => $data['title'] ?? null,
                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
                    'description' => $data['shortDescription'] ?? null,
                    'price' => isset($data['price']) ? intval($data['price']) : null,
                    'land_area' => $areaInSqm ? $areaInSqm / 418 : null,
                    'area_in_sqft' => $areaInSqm ? $areaInSqm * 10.7639 : null,
                    'area_unit' => 'Square Meters', // Default unit
                    'area_in_sqyd' => $areaInSqm ? $areaInSqm * 1.19599 : null,
                    'area_in_sqm' => $areaInSqm ?? null,
                    'area_in_marla' => $areaInSqm ? $areaInSqm / 25.2929 : null,
                    'area_in_new_marla' => $areaInSqm ? $areaInSqm / 20.9 : null,
                    'area_in_kanal' => $areaInSqm ? $areaInSqm / 505.857 : null,
                    'area_in_new_kanal' => $areaInSqm ? $areaInSqm / 418 : null,
                    'bedrooms' => $data['rooms'] ?? null,
                    'bathrooms' => $data['baths'] ?? null,
                    'latitude' => $data['_geoloc']['lat'] ?? null,
                    'longitude' => $data['_geoloc']['lng'] ?? null,
//                    'contact_person' => $data['phoneNumber']['mobile'] ?? null,
                    'phone' => $data['phoneNumber']['phone'] ?? null,
                    'cell' => $data['phoneNumber']['whatsapp'] ?? null,
                    'status' => 'active',
                    'is_active' => $data['isVerified'] ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'activated_at' => now(),
                ];
                try {
                    DB::table('properties')->insertGetId($propertyData);
                } catch (\Exception $e) {
                    dd('Error: ' . $e->getMessage());
                }
            }

            DB::commit();
            return 'JSON data inserted successfully!';
//            return redirect()->back()->with('success', 'JSON data inserted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error inserting JSON data: ' . $e->getMessage());
        }

    }

}

