<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HitRecord\HitController;
use App\Jobs\ScrapeAndInsertDataJob;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\FacebookPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    //    display data on index page
    public function index()
    {
        $filename = 'scraped_data.json';
        $timestampFile = 'scraped/last_scrape.txt';
        $lastScraped = 0;
        if (Storage::disk('local')->exists($timestampFile)) {
            $lastScraped = (int)Storage::disk('local')->get($timestampFile);
        }
        $now = time();
        if (($now - $lastScraped) >= 1209600) { // 1209600 seconds = 2 weeks, 14400 seconds = 4 hours
//            $this->scrapeData($filename);
            set_time_limit(300);
            ScrapeAndInsertDataJob::dispatch();
            Storage::disk('local')->put($timestampFile, $now);
            \Log::info('Scrape job dispatched at: ' . now());
        }

//        try {
//            HitController::record();
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//        }
        //$property  = Property::where('id',278917)->first();
        //$this->dispatch(new FacebookPost($property));
        (new MetaTagController())->addMetaTags();

//        if (!(new Visit)->hit()) {
//            return view('website.errors.404');
//        }

        (new Visit)->hit();

        $property_types = (new PropertyType)->all();

        // property count table
        $total_count = DB::table('total_property_count')->select('property_count', 'sale_property_count', 'rent_property_count', 'agency_count', 'city_count')->first();
        $footer_content = (new FooterController)->footerContent();

        $data = [
            'total_count' => $total_count,
            'cities_count' => (new CountTableController())->getCitiesCount(),
            'property_types' => $property_types,
            'localBusiness' => (new MetaTagController())->addScriptJsonldTag(),
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1],
        ];

        return view('website.index', $data);
    }
    private function scrapeData($filename)
    {
        $url = 'https://5BFU7FLVAD-dsn.algolia.net/1/indexes/zameen-production-ads-en/query';

        $headers = [
            'Accept-Encoding' => 'gzip',
            'X-Algolia-Application-Id' => '5BFU7FLVAD',
            'X-Algolia-API-Key' => '26bdc4a584b7955f4ee65e2c4744d479',
            'User-Agent' => 'Algolia for Android (3.27.0); Android (5.1.1)',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Host' => '5BFU7FLVAD-dsn.algolia.net',
            'Connection' => 'Keep-Alive',
            'sessionId' => 'a8c687ea-e178-4b4d-b54c-14a70f1e586a',
        ];

        $cities  = [
            "islamabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FIslamabad-3%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
            "lahore" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FLahore-1%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
            "karachi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FKarachi-2%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
            "rawalpindi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FRawalpindi-41%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=99000&page=0&query=new",

        ];

        foreach ($cities as $city => $query) {
            $body = ['params' => $query];
            $response = Http::withHeaders($headers)->post($url, $body);

            if ($response->successful()) {
                $filename = "scraped_{$city}.json";
                $relativePath = "scraped/{$filename}";
                Storage::disk('local')->put($relativePath, $response->body());
                // ✅ Insert to database
                $this->processScrapedJson($filename);
            } else {
                \Log::error('Scraping failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        }
//        $response = Http::withHeaders($headers)->post($url, $body);
//
//        if ($response->successful()) {
//            $path = "scraped/{$filename}";
//            Storage::disk('local')->put("scraped/{$filename}", $response->body());
//            // ✅ Insert to database
//            $this->processScrapedJson($path);
//        } else {
//            \Log::error('Scraping failed', [
//                'status' => $response->status(),
//                'body' => $response->body(),
//            ]);
//        }
    }

    private function processScrapedJson($filename)
    {
        $fullPath = base_path("property_media/public/{$filename}");
        if (!file_exists($fullPath)) {
            \Log::error("Scraped file not found at path: $fullPath");
            return false;
        }

        $jsonData = json_decode(file_get_contents($fullPath), true);

        if (!isset($jsonData['hits'])) {
            \Log::error('Invalid JSON format - "hits" not found');
            return false;
        }

        try {
            DB::beginTransaction();

            foreach ($jsonData['hits'] as $data) {
                $areaInSqm = $data['area'] ?? null;
                $locationId = null;
                $agencyId = null;

                // City lookup
                $getCityId = $data['location'][2]['name'] ?? null;
                $city = City::where('name', str_replace('_', ' ', $getCityId))->first();

                // Location insert or fetch
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
                            'latitude' => $data['_geoloc']['lat'],
                            'longitude' => $data['_geoloc']['lng'],
                        ]);
                    } else {
                        $locationId = $location->id;
                    }
                }

                // Agency insert or fetch
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

                // Property reference
                do {
                    $reference = date("Y") . '-' . str_pad(random_int(10000000, 99999999), 8, "0", STR_PAD_LEFT);
                    $exists = DB::table('properties')->where('reference', $reference)->exists();
                } while ($exists);

                // Property data
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
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+2 months', $data['createdAt'])),
                ];

                DB::table('properties')->insert($propertyData);
                // ✅ Delete the file after successful commit
//                unlink($fullPath);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error processing JSON: ' . $e->getMessage());
            return false;
        }
    }


    public function updateCount()
    {
        try {
            $totalCount = Property::count();
            $rentPropertyCount = Property::where('purpose', 'Rent')->count();
            $salePropertyCount = Property::where('purpose', 'Sale')->count();
            $agencyPropertyCount = Agency::where('is_active', '1')->count();
            $cityCount = City::count();

            DB::table('total_property_count')->update([
                'property_count' => $totalCount,
                'rent_property_count' => $rentPropertyCount,
                'sale_property_count' => $salePropertyCount,
                'agency_count' => $agencyPropertyCount,
                'city_count' => $cityCount,
            ]);

            return response()->json([
                'message' => 'Counts updated successfully',
                'data' => [
                    'property_count' => $totalCount,
                    'rent_property_count' => $rentPropertyCount,
                    'sale_property_count' => $salePropertyCount,
                    'agency_count' => $agencyPropertyCount,
                    'city_count' => $cityCount,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update counts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
