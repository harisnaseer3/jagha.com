<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyBackendListingController extends Controller
{
    /*
     * Display the specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string status     required    active|edited|pending|expired|uploaded|hidden|deleted|rejected|rejected_images|rejected_videos
     * @param string user       optional    id|all
     */

    private function listingsCount($status, $user)
    {
        $condition = ['property_status' => $status, 'user_id' => $user];
        return DB::table('property_count_by_status_and_purposes')->select(DB::raw('sum(property_count) as count'))->where($condition);

    }

    private function _listings(string $status, string $user, $city = '')
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = Property::
        select('properties.id', 'sub_type AS type',  'properties.reference',
            'properties.status', 'locations.name AS location', 'cities.name as city',
            'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
            'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
            'price', 'properties.created_at AS listed_date', 'properties.created_at', DB::raw("'0' AS quota_used"),
            DB::raw("'0' AS image_views"))
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');

        // user
//        TODO: based on property role admin
//        if (!Auth::user()->hasRole('Admin')) {
        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            }
            //if user owns agencies{}
            $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);

            $ceo_agencies = Agency::where('user_id', '=', $user)->pluck('id')->toArray(); //gives ceo of agency
            $agent_agencies = DB::table('agency_users')->where('user_id', $user)->pluck('agency_id')->toArray(); //gives all agency users
            if (count($ceo_agencies) > 0) {
                //get all individual properties

                $agency_users = DB::table('agency_users')->whereIn('agency_id', $ceo_agencies)->distinct('user_id')->pluck('user_id')->toArray();
                $ceo_listings = Property::select('properties.id', 'sub_type AS type', 'properties.reference',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', DB::raw("'0' AS quota_used"),
                    DB::raw("'0' AS image_views"))
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agencies)
                    ->whereIn('properties.user_id', $agency_users);
                $ceo_listings = $status == 'all' ? $ceo_listings : $ceo_listings->where('status', '=', $status);
                return $ceo_listings->union($listings);
            } elseif ($agent_agencies > 0) {
                $agent_listings = Property::
                select('properties.id', 'sub_type AS type', 'properties.reference',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', DB::raw("'0' AS quota_used"),
                    DB::raw("'0' AS image_views"))
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->whereNull('properties.deleted_at')
                    ->whereIn('properties.agency_id', $agent_agencies)
                    ->where('properties.user_id', $user);
                $agent_listings = $status == 'all' ? $agent_listings : $agent_listings->where('status', '=', $status);
                return $agent_listings->union($listings);
            }
            //in each case of ceo agent or individual user
            return $listings;

        }
        if ($status == 'all') {
            return $listings;
        } else {
            return $listings->where('status', '=', $status);

        }
    }

    /*
     * Display the specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string status     required    active|edited|pending|expired|uploaded|hidden|deleted|rejected|rejected_images|rejected_videos
     * @param string purpose    required    all|sale|rent|wanted|super_hot_listing|hot_listing|magazine_listing
     * @param string user       optional    id|all
     * @param string sort       optional    id|type|location|price|expiry|views|image_count
     * @param string order      optional    asc|desc
     * @param string page       optional    10|15|30|50
     */

    private function _getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page)
    {
        $all = null;
        $sale = null;
        $rent = null;
        $wanted = null;
        $golden = null;
        $silver = null;
        $basic = null;
        $bronze = null;
        $platinum = null;

        if ($purpose === 'all') {
            $all = $this->_listings($status, $user)->where($condition)->orderBy($sort, $order)->paginate($page);
        }
        if ($purpose === 'sale') {
            $sale = $this->_listings($status, $user)->where('purpose', '=', 'sale')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'rent') {
            $rent = $this->_listings($status, $user)->where('purpose', '=', 'rent')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'wanted') {
            $wanted = $this->_listings($status, $user)->where('purpose', '=', 'wanted')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'golden') {
            $golden = $this->_listings($status, $user)->where('golden_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'silver') {
            $silver = $this->_listings($status, $user)->where('silver_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'basic') {
            $basic = $this->_listings($status, $user)->where('basic_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'bronze') {
            $bronze = $this->_listings($status, $user)->where('bronze_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'platinum') {
            $platinum = $this->_listings($status, $user)->where('platinum_listing', '=', 1)->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        return ['all' => $all, 'sale' => $sale, 'rent' => $rent, 'wanted' => $wanted, 'golden' => $golden, 'platinum' => $platinum, 'silver' => $silver, 'basic' => $basic, 'bronze' => $bronze];
    }

    public function listings(string $status, string $purpose, string $user, string $sort, string $order, string $page, Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $user = 1;
        } else if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->getAuthIdentifier();
        }

        $property_count = $this->getPropertyListingCount($user);
        $footer_content = (new FooterController)->footerContent();
        if ($request->has('city')) {
            $city = (new City)->select('id')->where('name', '=', str_replace('-', ' ', $request->city))->first();
            $condition = ['properties.city_id' => $city->id];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => 'admin',
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
            ];

            return view('website.admin-pages.listings', $data);
        }

        if ($request->has('id')) {
            $condition = ['properties.id' => $request->input('id')];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => 'admin',
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
            ];

            return view('website.admin-pages.listings', $data);
        } else if ($request->has('reference')) {
            $condition = ['properties.reference' => $request->input('reference')];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => $user,
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'notifications' => Auth()->user()->unreadNotifications,
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];
            if ($data['listings']['all'])
                return redirect()->back()->withInput()->with('error', 'Property not found.');

            return view('website.pages.listings', $data);
        }

        // TODO: implement code where status is rejected_images or rejected_videos, remove after
        if (in_array($status, ['rejected_images', 'rejected_videos'])) {
            return abort(404, 'Missing implementation');
        }

        // listing of status
        $status = strtolower($status);
        if (!in_array($status, ['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold', 'rejected_images', 'rejected_videos'])) {
            return redirect()->back(302)->withInput()->withErrors(['message', 'Invalid status provided.']);
        }

        // sort by field
        $sort = strtolower($sort);
        if (!in_array($sort, ['id', 'type', 'location', 'price', 'expiry', 'views', 'image_count'])) {
            $sort = 'id';
        } elseif ($sort === 'image_count') {
            // TODO: find image count and make it part of query
            // $listings->join('images', 'properties.id', '=', 'images.properties.id');
            $sort = 'id';
        } else {
            if ($sort === 'id') $sort = 'id';
            elseif ($sort === 'type') $sort = 'sub_type';
            elseif ($sort === 'location') $sort = 'locations.name';
            elseif ($sort === 'expiry') $sort = 'created_at';
        }


        // order -> ascending or descending
        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        // pagination
        if (!in_array($page, [10, 15, 30, 50, 200])) {
            $page = 10;
        }

        if (Auth::guard('admin')->user()) {
            $condition = [];
            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);

            $data = [
                'params' => [
                    'status' => $status,
                    'purpose' => $purpose,
                    'user' => $user,
                    'sort' => $sort,
                    'order' => $order,
                    'page' => $page,
                ],
                'counts' => $property_count,
                'listings' => [
                    'all' => $result['all'],
                    'sale' => $result['sale'],
                    'rent' => $result['rent'],
                    'wanted' => $result['wanted'],
                    'basic' => $result['basic'],
                    'silver' => $result['silver'],
                    'bronze' => $result['bronze'],
                    'golden' => $result['golden'],
                    'platinum' => $result['platinum'],
                ],
            ];

            return view('website.admin-pages.listings', $data);
        }
        $condition = [];
        $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
        $data = [
            'params' => [
                'status' => $status,
                'purpose' => $purpose,
                'user' => $user,
                'sort' => $sort,
                'order' => $order,
                'page' => $page,
            ],
//            'notifications' => Auth()->user()->unreadNotifications,
            'counts' => $property_count,
            'listings' => [
                'all' => $result['all'],
                'sale' => $result['sale'],
                'rent' => $result['rent'],
                'wanted' => $result['wanted'],
                'basic' => $result['basic'],
                'silver' => $result['silver'],
                'bronze' => $result['bronze'],
                'golden' => $result['golden'],
                'platinum' => $result['platinum'],
            ],
            'recent_properties' => $footer_content[0],
            'footer_agencies' => $footer_content[1]
        ];
        return view('website.pages.listings', $data);
    }


    /*
     * Count specified resource under various categories like Active, Edited, Pending, Expired, Uploaded, Hidden, Deleted, Rejected, Rejected Images, Rejected Videos
     *
     * @param string user       optional    id|all
     * @param string sort       optional    id|type|location|price|expiry|views|image_count
     * @param string order      optional    asc|desc
     */
    public function getPropertyListingCount(string $user)
    {
        $counts = [];
        foreach (['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold'] as $status) {
            $counts[$status]['all'] = $this->listingsCount($status, $user)->first()->count;
            $counts[$status]['sale'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'sale')->first()->count;
            $counts[$status]['rent'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'rent')->first()->count;
            $counts[$status]['wanted'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'wanted')->first()->count;

            if ($status === 'active') {
                $counts[$status]['basic'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'basic_listing')->first()->count;
                $counts[$status]['silver'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'silver_listing')->first()->count;
                $counts[$status]['bronze'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'bronze_listing')->first()->count;
                $counts[$status]['golden'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'golden_listing')->first()->count;
                $counts[$status]['platinum'] = $this->listingsCount($status, $user)->where('listing_type', '=', 'platinum_listing')->first()->count;
            }
        }
        return $counts;
    }


    private function _getPropertyAggregates()
    {
        // fetch count of properties by city
        $cities = (new Property)
            ->select('cities.name AS city_name', DB::raw('COUNT(properties.id) AS count'))
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->where('properties.status', '=', 'active')
            ->groupBy('properties.city_id')
            ->orderBy('cities.id')
            ->get();

        // fetch min/max land_area, count of properties on rent/sale/wanted, count of homes/plots/commercial properties
        $properties_area_range = DB::table('properties')
            ->select(DB::raw('MIN(land_area) AS min_area'), DB::raw('MAX(land_area) AS max_area'))
            ->where('status', '=', 'active')
            ->first();
        $properties_rent_count = DB::table('properties')->where('purpose', '=', 'Rent')->where('status', '=', 'active')->count();
        $properties_sale_count = DB::table('properties')->where('purpose', '=', 'Sale')->where('status', '=', 'active')->count();
        $properties_wanted_count = DB::table('properties')->where('purpose', '=', 'Wanted')->where('status', '=', 'active')->count();
        $properties_homes_count = DB::table('properties')->where('type', '=', 'Homes')->where('status', '=', 'active')->count();
        $properties_plots_count = DB::table('properties')->where('type', '=', 'Plots')->where('status', '=', 'active')->count();
        $properties_commercial_count = DB::table('properties')->where('type', '=', 'Commercial')->where('status', '=', 'active')->count();

        return [
            'cities' => $cities,
            'min_area' => $properties_area_range->min_area,
            'max_area' => $properties_area_range->max_area,
            'rent_count' => $properties_rent_count,
            'sale_count' => $properties_sale_count,
            'wanted_count' => $properties_wanted_count,
            'homes_count' => $properties_homes_count,
            'plots_count' => $properties_plots_count,
            'commercial_count' => $properties_commercial_count,
        ];
    }
}
