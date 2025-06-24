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
//        set_time_limit(0); // Allow long execution time
//        $file = $request->file('json_file');
//        $jsonData = json_decode(file_get_contents($file), true);
//
//        if (!isset($jsonData['hits'])) {
//            return back()->withErrors(['Invalid JSON file format']);
//        }
//
//        try {
//            DB::beginTransaction();
//            foreach ($jsonData['hits'] as $data) {
//                $areaInSqm = $data['area'] ?? null;
//                $locationId = null;
//                $agencyId = null;
//
//                // Get city ID
//                $getCityId = $data['location'][2]['name'] ?? null;
//                $city = City::where('name', str_replace('_', ' ', $getCityId))->first();
//
//                // Insert Location
//                if (isset($data['_geoloc'])) {
//                    $location = DB::table('locations')->where([
//                        'latitude' => $data['_geoloc']['lat'],
//                        'longitude' => $data['_geoloc']['lng']
//                    ])->first();
//
//                    if (!$location) {
//                        $locationId = DB::table('locations')->insertGetId([
//                            'user_id' => 1,
//                            'city_id' => $city->id ?? 1,
//                            'name' => $data['location'][3]['name'] ?? null,
//                            'latitude' => $data['_geoloc']['lat'] ?? null,
//                            'longitude' => $data['_geoloc']['lng'] ?? null,
//                        ]);
//                    } else {
//                        $locationId = $location->id;
//                    }
//                }
//                // Insert Agency
//                if (isset($data['agency'])) {
//                    $agency = DB::table('agencies')->where('title', $data['agency']['name'])->first();
//
//                    if (!$agency) {
//                        $agencyId = DB::table('agencies')->insertGetId([
//                            'user_id' => 1,
//                            'city_id' => $city->id ?? 1,
//                            'title' => $data['agency']['name'] ?? null,
//                            'description' => $data['agency']['name_l1'] ?? null,
//                            'country' => 'Pakistan',
//                        ]);
//                    } else {
//                        $agencyId = $agency->id;
//                    }
//                }
//
//                // ✅ Unique Property Reference Fix
//                do {
//                    $reference = date("Y") . '-' . str_pad(random_int(10000000, 99999999), 8, "0", STR_PAD_LEFT);
//                    $existingReference = DB::table('properties')->where('reference', $reference)->exists();
//                } while ($existingReference);
//
//                // Prepare Property Data
//                $propertyData = [
//                    'user_id' => 1,
//                    'reference' => $reference,
//                    'city_id' => $city->id ?? 1,
//                    'location_id' => $locationId,
//                    'agency_id' => $agencyId,
//                    'purpose' => ($data['purpose'] === 'for-sale') ? 'Sale' : (($data['purpose'] === 'for-rent') ? 'Rent' : $data['purpose']),
//                    'type' => $data['category'][0]['name'] ?? null,
//                    'sub_type' => isset($data['category'][1]['nameSingular']) ? ucfirst(strtolower($data['category'][1]['nameSingular'])) : null,
//                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
//                    'description' => $data['shortDescription'] ?? null,
//                    'price' => intval($data['price'] ?? 0),
//                    'land_area' => $areaInSqm ? $areaInSqm / 418 : null,
//                    'area_in_sqft' => $areaInSqm ? $areaInSqm * 10.7639 : null,
//                    'area_unit' => 'Square Meters',
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
//                    'phone' => $data['phoneNumber']['phone'] ?? null,
//                    'cell' => $data['phoneNumber']['whatsapp'] ?? null,
//                    'status' => 'active',
//                    'is_active' => $data['isVerified'] ? 1 : 0,
//                    'created_at' => date('Y-m-d H:i:s', $data['createdAt']),
//                    'updated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
//                    'activated_at' => date('Y-m-d H:i:s', $data['updatedAt']),
//                    'expired_at' => date('Y-m-d H:i:s', strtotime('+2 months', $data['createdAt'])), // Calculate expired_at
//                ];
//
//                // Insert Property
//                DB::table('properties')->insert($propertyData);
//            }
//
//            DB::commit();
//            return response()->json(['message' => 'JSON data inserted successfully!'], 200);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json(['error' => 'Error processing data: ' . $e->getMessage()], 500);
//        }
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

            $existingDescriptions = DB::table('properties')->pluck('description')->toArray(); // DB descriptions
            $alreadySeen = []; // Prevent duplicates within same JSON file

            foreach ($jsonData['hits'] as $data) {
                $description = $data['shortDescription'] ?? null;

                // Skip if description is empty or already exists
                if (!$description || in_array($description, $existingDescriptions) || in_array($description, $alreadySeen)) {
                    continue;
                }

                $alreadySeen[] = $description;

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

                // Generate Unique Reference
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
                    'purpose' => ($data['purpose'] === 'for-sale') ? 'Sale' : (($data['purpose'] === 'for-rent') ? 'Rent' : $data['purpose']),
                    'type' => $data['category'][0]['name'] ?? null,
                    'sub_type' => isset($data['category'][1]['nameSingular']) ? ucfirst(strtolower($data['category'][1]['nameSingular'])) : null,
                    'title' => isset($data['title']) ? Str::limit($data['title'], 50, '...') : null,
                    'description' => $description,
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
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+2 months', $data['createdAt'])),
                ];

                DB::table('properties')->insert($propertyData);
            }

            DB::commit();
            return response()->json(['message' => 'JSON data inserted successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error processing data: ' . $e->getMessage()], 500);
        }
    }

}

