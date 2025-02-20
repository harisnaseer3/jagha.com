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
//    public function processUpload(Request $request)
//    {
//        // Retrieve and decode the JSON file
//        $file = $request->file('json_file');
//        $jsonData = json_decode(file_get_contents($file), true);
//
//        if (!isset($jsonData['hits'])) {
//            return back()->withErrors(['Invalid JSON file format']);
//        }
//
//        try {
//            DB::beginTransaction();
//
//            foreach ($jsonData['hits'] as $data) {
//                // Transform the data for the `properties` table
//                $areaInSqm = $data['area'];
//                $locationId = null;
//                $agencyId = null;
//
//                $getCityId = isset($data['location'][2]['name']) ? $data['location'][2]['name'] : null;
//                $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $getCityId))->first();
//
//                // Insert related location data into `locations` table
//                if (isset($data['_geoloc'])) {
//                    $locationId = DB::table('locations')->insertGetId([
//                        'user_id' => 1,
//                        'city_id' => 1,
//                        'name' => isset($data['location'][3]['name']) ? $data['location'][3]['name'] : null,
//                        'latitude' => $data['_geoloc']['lat'] ?? null,
//                        'longitude' => $data['_geoloc']['lng'] ?? null,
//                    ]);
//                }
////
////                // Transform and insert data for the `agencies` table
//                if (isset($data['agency'])) {
//                    $agencyId = DB::table('agencies')->insertGetId([
//                        'user_id' => 1,
//                        'city_id' => $city->id,
//                        'title' => $data['agency']['name'] ?? null,
//                        'description' => $data['agency']['name_l1'] ?? null,
//                        'country' => 'Pakistan',
//                    ]);
//                    DB::table('property_count_by_agencies')->insertGetId([
//                        'agency_id' => $agencyId,
//                        'property_status' => 'active',
//                        'listing_type' => 'basic_listing',
//                    ]);
//                }
//
//                $max_id = 0;
//                $max_id = DB::table('properties')->select('id')->orderBy('id', 'desc')->first()->id;
//                $max_id = $max_id + 1;
//                $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
//
//                    // Prepare property data
//                $propertyData = [
//                    'user_id' => 1,
//                    'reference' => $reference ?? null,
//                    'city_id' => $city->id,
//                    'location_id' => $locationId,
//                    'agency_id' => $agencyId,
//                    'purpose' => $data['purpose'] === 'for-sale' ? 'Sale' : $data['purpose'],
//                    'type' => isset($data['category'][0]['name']) ? $data['category'][0]['name'] : null,
//                    'sub_type' => isset($data['category'][1]['name']) ?
//                        (strtolower($data['category'][1]['name']) === 'houses' ? 'House' : $data['category'][1]['name'])
//                        : null,
////                    'title' => $data['title'] ?? null,
//                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
//                    'description' => $data['shortDescription'] ?? null,
//                    'price' => isset($data['price']) ? intval($data['price']) : null,
//                    'land_area' => $areaInSqm ? $areaInSqm / 418 : null,
//                    'area_in_sqft' => $areaInSqm ? $areaInSqm * 10.7639 : null,
//                    'area_unit' => 'Square Meters', // Default unit
//                    'area_in_sqyd' => $areaInSqm ? $areaInSqm * 1.19599 : null,
//                    'area_in_sqm' => $areaInSqm ?? null,
//                    'area_in_marla' => $areaInSqm ? $areaInSqm / 25.2929 : null,
//                    'area_in_new_marla' => $areaInSqm ? $areaInSqm / 20.9 : null,
//                    'area_in_kanal' => $areaInSqm ? $areaInSqm / 505.857 : null,
//                    'area_in_new_kanal' => $areaInSqm ? $areaInSqm / 418 : null,
//                    'bedrooms' => $data['rooms'] ?? null,
//                    'bathrooms' => $data['baths'] ?? null,
//                    'latitude' => $data['_geoloc']['lat'] ?? null,
//                    'longitude' => $data['_geoloc']['lng'] ?? null,
////                    'contact_person' => $data['phoneNumber']['mobile'] ?? null,
//                    'phone' => $data['phoneNumber']['phone'] ?? null,
//                    'cell' => $data['phoneNumber']['whatsapp'] ?? null,
//                    'status' => 'active',
//                    'is_active' => $data['isVerified'] ? 1 : 0,
//                    'created_at' => date('Y-m-d H:i:s', $data['createdAt']),
//                    'updated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
//                    'activated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
//                ];
//                try {
//                    DB::table('properties')->insertGetId($propertyData);
//                } catch (\Exception $e) {
//                    dd('Error: ' . $e->getMessage());
//                }
//            }
//
//            DB::commit();
//            return 'JSON data inserted successfully!';
////            return redirect()->back()->with('success', 'JSON data inserted successfully!');
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return redirect()->back()->with('error', 'Error inserting JSON data: ' . $e->getMessage());
//        }
//
//    }

    public function processUpload(Request $request)
    {
        set_time_limit(0); // Allow long execution time
        $file = $request->file('json_file');
        $jsonData = json_decode(file_get_contents($file), true);

        if (!isset($jsonData['hits'])) {
            return back()->withErrors(['Invalid JSON file format']);
        }

        try {
            DB::beginTransaction();
            foreach ($jsonData['hits'] as $data) {
                $areaInSqm = $data['area'] ?? null;
                $locationId = null;
                $agencyId = null;

                // Get city ID
                $getCityId = $data['location'][2]['name'] ?? null;
                $city = City::where('name', str_replace('_', ' ', $getCityId))->first();

                // Insert Location
                if (isset($data['_geoloc'])) {
                    $location = DB::table('locations')->where([
                        'latitude' => $data['_geoloc']['lat'],
                        'longitude' => $data['_geoloc']['lng']
                    ])->first();

                    if (!$location) {
                        $locationId = DB::table('locations')->insertGetId([
                            'user_id' => 1,
                            'city_id' => $city->id ?? 1,
                            'name' => $data['location'][3]['name'] ?? null,
                            'latitude' => $data['_geoloc']['lat'] ?? null,
                            'longitude' => $data['_geoloc']['lng'] ?? null,
                        ]);
                    } else {
                        $locationId = $location->id;
                    }
                }
                // Insert Agency
                if (isset($data['agency'])) {
                    $agency = DB::table('agencies')->where('title', $data['agency']['name'])->first();

                    if (!$agency) {
                        $agencyId = DB::table('agencies')->insertGetId([
                            'user_id' => 1,
                            'city_id' => $city->id ?? 1,
                            'title' => $data['agency']['name'] ?? null,
                            'description' => $data['agency']['name_l1'] ?? null,
                            'country' => 'Pakistan',
                        ]);
                    } else {
                        $agencyId = $agency->id;
                    }
                }

                // ✅ Unique Property Reference Fix
                do {
                    $reference = date("Y") . '-' . str_pad(random_int(10000000, 99999999), 8, "0", STR_PAD_LEFT);
                    $existingReference = DB::table('properties')->where('reference', $reference)->exists();
                } while ($existingReference);

                // Prepare Property Data
                $propertyData = [
                    'user_id' => 1,
                    'reference' => $reference,
                    'city_id' => $city->id ?? 1,
                    'location_id' => $locationId,
                    'agency_id' => $agencyId,
                    'purpose' => $data['purpose'] === 'for-sale' ? 'Sale' : $data['purpose'],
                    'type' => $data['category'][0]['name'] ?? null,
                    'sub_type' => isset($data['category'][1]['name']) ? ucfirst(strtolower($data['category'][1]['name'])) : null,
                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
                    'description' => $data['shortDescription'] ?? null,
                    'price' => intval($data['price'] ?? 0),
                    'land_area' => $areaInSqm ? $areaInSqm / 418 : null,
                    'area_in_sqft' => $areaInSqm ? $areaInSqm * 10.7639 : null,
                    'area_unit' => 'Square Meters',
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
                    'phone' => $data['phoneNumber']['phone'] ?? null,
                    'cell' => $data['phoneNumber']['whatsapp'] ?? null,
                    'status' => 'active',
                    'is_active' => $data['isVerified'] ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s', $data['createdAt']),
                    'updated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
                    'activated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
                ];

                // Insert Property
                DB::table('properties')->insert($propertyData);
            }

            DB::commit();
            return response()->json(['message' => 'JSON data inserted successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error processing data: ' . $e->getMessage()], 500);
        }
    }


//    public function processUpload(Request $request)
//    {
//        set_time_limit(0); // Remove execution time limit
//
//        $file = $request->file('json_file');
//        $jsonData = json_decode(file_get_contents($file), true);
//
//        if (!isset($jsonData['hits'])) {
//            return back()->withErrors(['Invalid JSON file format']);
//        }
//
//        try {
//            DB::beginTransaction();
//
//            $locationsToInsert = [];
//            $agenciesToInsert = [];
//            $propertiesToInsert = [];
//            $batchSize = 500; // Process 500 records at a time
//
//            foreach ($jsonData['hits'] as $index => $data) {
//                $areaInSqm = $data['area'] ?? null;
//
//                // Fetch city ID
//                $cityName = $data['location'][2]['name'] ?? null;
//                $city = DB::table('cities')->where('name', str_replace('_', ' ', $cityName))->first();
//
//                // Process Location
//                $locationId = null;
//                if (isset($data['_geoloc'])) {
//                    $location = DB::table('locations')
//                        ->where('latitude', $data['_geoloc']['lat'])
//                        ->where('longitude', $data['_geoloc']['lng'])
//                        ->first();
//
//                    if (!$location) {
//                        $locationsToInsert[] = [
//                            'user_id' => 1,
//                            'city_id' => $city->id ?? 1,
//                            'name' => $data['location'][3]['name'] ?? null,
//                            'latitude' => $data['_geoloc']['lat'],
//                            'longitude' => $data['_geoloc']['lng'],
//                        ];
//                    } else {
//                        $locationId = $location->id;
//                    }
//                }
//
//                // Process Agency
//                $agencyId = null;
//                if (isset($data['agency'])) {
//                    $agency = DB::table('agencies')->where('title', $data['agency']['name'])->first();
//
//                    if (!$agency) {
//                        $agenciesToInsert[] = [
//                            'user_id' => 1,
//                            'city_id' => $city->id ?? 1,
//                            'title' => $data['agency']['name'],
//                            'description' => $data['agency']['name_l1'] ?? null,
//                            'country' => 'Pakistan',
//                        ];
//                    } else {
//                        $agencyId = $agency->id;
//                    }
//                }
//
//                // Generate unique property reference
//                $max_id = DB::table('properties')->max('id') + 1;
//                $reference = date("Y") . '-' . str_pad($max_id, 8, 0, STR_PAD_LEFT);
//
//                // Check if property exists
//                $existingProperty = DB::table('properties')
//                    ->where('latitude', $data['_geoloc']['lat'])
//                    ->where('longitude', $data['_geoloc']['lng'])
//                    ->first();
//
//                $propertyData = [
//                    'user_id' => 1,
//                    'reference' => $reference,
//                    'city_id' => $city->id ?? 1,
//                    'location_id' => $locationId,
//                    'agency_id' => $agencyId,
//                    'purpose' => $data['purpose'] === 'for-sale' ? 'Sale' : $data['purpose'],
//                    'type' => $data['category'][0]['name'] ?? null,
//                    'sub_type' => isset($data['category'][1]['name']) ? ucfirst(strtolower($data['category'][1]['name'])) : null,
//                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
//                    'description' => $data['shortDescription'] ?? null,
//                    'price' => intval($data['price'] ?? 0),
//                    'land_area' => $areaInSqm ? $areaInSqm / 418 : null,
//                    'area_in_sqft' => $areaInSqm ? $areaInSqm * 10.7639 : null,
//                    'area_unit' => 'Square Meters',
//                    'area_in_sqyd' => $areaInSqm ? $areaInSqm * 1.19599 : null,
//                    'area_in_marla' => $areaInSqm ? $areaInSqm / 25.2929 : null,
//                    'area_in_new_marla' => $areaInSqm ? $areaInSqm / 20.9 : null,
//                    'area_in_kanal' => $areaInSqm ? $areaInSqm / 505.857 : null,
//                    'area_in_new_kanal' => $areaInSqm ? $areaInSqm / 418 : null,
//                    'bedrooms' => $data['rooms'] ?? null,
//                    'bathrooms' => $data['baths'] ?? null,
//                    'latitude' => $data['_geoloc']['lat'] ?? null,
//                    'longitude' => $data['_geoloc']['lng'] ?? null,
//                    'phone' => $data['phoneNumber']['phone'] ?? null,
//                    'cell' => $data['phoneNumber']['whatsapp'] ?? null,
//                    'status' => 'active',
//                    'is_active' => $data['isVerified'] ? 1 : 0,
//                    'updated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
//                    'activated_at' => date('Y-m-d H:i:s', $data['updatedAt']),,
//                ];
//
//                if ($existingProperty) {
//                    DB::table('properties')->where('id', $existingProperty->id)->update($propertyData);
//                } else {
//                    $propertyData['created_at'] = now();
//                    $propertiesToInsert[] = $propertyData;
//                }
//
//                // Insert in batches
//                if ($index % $batchSize === 0) {
//                    if (!empty($locationsToInsert)) {
//                        DB::table('locations')->insertOrIgnore($locationsToInsert);
//                        $locationsToInsert = [];
//                    }
//
//                    if (!empty($agenciesToInsert)) {
//                        DB::table('agencies')->insertOrIgnore($agenciesToInsert);
//                        $agenciesToInsert = [];
//                    }
//
//                    if (!empty($propertiesToInsert)) {
//                        DB::table('properties')->insertOrIgnore($propertiesToInsert);
//                        $propertiesToInsert = [];
//                    }
//                }
//            }
//
//            // Final batch insert
//            if (!empty($locationsToInsert)) {
//                DB::table('locations')->insertOrIgnore($locationsToInsert);
//            }
//
//            if (!empty($agenciesToInsert)) {
//                DB::table('agencies')->insertOrIgnore($agenciesToInsert);
//            }
//
//            if (!empty($propertiesToInsert)) {
//                DB::table('properties')->insertOrIgnore($propertiesToInsert);
//            }
//
//            DB::commit();
//            return response()->json(['message' => 'JSON data inserted/updated successfully!'], 200);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json(['error' => 'Error processing data: ' . $e->getMessage()], 500);
//        }
//    }

}

