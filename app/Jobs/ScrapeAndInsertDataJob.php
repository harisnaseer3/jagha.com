<?php

namespace App\Jobs;

use App\Models\Dashboard\City;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScrapeAndInsertDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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

        $last24Hours = time() - (24 * 60 * 60); // UNIX timestamp 24 hours ago
//        $cities  = [
//            "islamabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FIslamabad-3%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
//            "lahore" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FLahore-1%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
//            "karachi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FKarachi-2%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=10000&page=0&query=new",
//            "rawalpindi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FRawalpindi-41%20AND%20category.slug%3A%22Houses_Property%22&hitsPerPage=99000&page=0&query=new",
//
//        ];
        $cities = [
            "islamabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FIslamabad-3%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "lahore" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FLahore-1%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "karachi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FKarachi-2%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "rawalpindi" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FRawalpindi-41%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "attock" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FAttock-1233%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "multan" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FMultan-15%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "gujranwala" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FGujranwala-327%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "faisalabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FFaisalabad-16%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "dera_ghazi_khan" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FDera_Ghazi_Khan-26%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "abbottabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FAbbottabad-385%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "bahawalpur" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FBahawalpur-23%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "hyderabad" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FHyderabad-30%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "quetta" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FQuetta-18%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "rahim_yar_khan" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FRahim_Yar_Khan-40%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "okara" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FOkara-470%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "lalamusa" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FLalamusa-9837%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "mianwali" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FMianwali-8310%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "mandi_bahauddin" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FMandi_Bahauddin-1496%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "taxila" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FTaxila-464%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "peshawar" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FPeshawar-17%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "mardan" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FMardan-440%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "murree" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FMurree-36%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "sialkot" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FSialkot-480%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",
            "sargodha" => "filters=purpose%3A%22for-sale%22%20AND%20location.slug%3A%2FSargodha-778%20AND%20category.slug%3A%22Houses_Property%22%20AND%20createdAt%20%3E%20{$last24Hours}&hitsPerPage=10000&page=0&query=new",

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
        // ✅ Update last scrape timestamp
        Storage::disk('local')->put('scraped/last_scrape.txt', time());
    }

    private function processScrapedJson($filename)
    {
        $fullPath = base_path("property_media/public/scraped/{$filename}");
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
            \Log::info("Inserted " . count($jsonData['hits']) . " properties from {$filename}");
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error processing JSON: ' . $e->getMessage());
            return false;
        }
    }
}
