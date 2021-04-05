<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\AgencyUser;
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
    { // individual + agency + agent properties
        //if ceo get all properties of agency
        //if get get only his properties
        //if both get both

        $condition = ['property_status' => $status];
        return DB::table('property_count_for_admin')->select(DB::raw('property_count as count'))->where($condition);

    }

    private function _listings(string $status, string $user, $condition, $city = '')
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = Property:: select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
            'properties.status', 'locations.name AS location', 'cities.name as city',
            'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
            'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
            'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id',
            'properties.cell', 'properties.agency_id', DB::raw("'0' AS quota_used"),
            DB::raw("'0' AS image_views"))
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->whereNull('properties.deleted_at');


        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            }
            //if user owns agencies{}
            $listings = $listings->where('properties.user_id', '=', $user)->where('properties.agency_id', '=', null);
            $listings = $status == 'all' ? $listings : $listings->where('status', '=', $status);

            $ceo_agencies = Agency::where('user_id', '=', $user)->pluck('id')->toArray(); //gives ceo of agency
            $agent_agencies = DB::table('agency_users')->where('user_id', $user)->pluck('agency_id')->toArray(); //gives all agency users
            if (count($ceo_agencies) > 0) {
                //get all individual properties

                $agency_users = DB::table('agency_users')->whereIn('agency_id', $ceo_agencies)->distinct('user_id')->pluck('user_id')->toArray();
                $ceo_agent_agencies = DB::table('agency_users')
                    ->where('user_id', '=', $user)
                    ->whereNotIn('agency_id', $ceo_agencies)->pluck('agency_id')->toArray();


                $ceo_listings = Property::select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id', 'properties.cell', 'properties.agency_id', DB::raw("'0' AS quota_used"),
                    DB::raw("'0' AS image_views"))
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agencies)
                    ->whereIn('properties.user_id', $agency_users);

                $ceo_agent_listings = Property::select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id', 'properties.cell', 'properties.agency_id', DB::raw("'0' AS quota_used"),
                    DB::raw("'0' AS image_views"))
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->whereNull('properties.deleted_at')->whereIn('properties.agency_id', $ceo_agent_agencies)
                    ->where('properties.user_id', $user);

                if ($status != 'all') {
                    $ceo_listings = $ceo_listings->where('status', '=', $status);
                    $ceo_agent_listings = $ceo_agent_listings->where('status', '=', $status);
                }
                return $ceo_listings->where($condition)->unionAll($listings->where($condition))->unionAll($ceo_agent_listings->where($condition));
            } elseif ($agent_agencies > 0) {
                $agent_listings = Property::
                select('properties.id', 'sub_type AS type', 'properties.reference', 'properties.purpose',
                    'properties.status', 'locations.name AS location', 'cities.name as city',
                    'properties.activated_at', 'properties.expired_at', 'properties.reviewed_by', 'properties.basic_listing', 'properties.bronze_listing',
                    'properties.silver_listing', 'properties.golden_listing', 'properties.platinum_listing',
                    'price', 'properties.created_at AS listed_date', 'properties.created_at', 'properties.contact_person', 'properties.user_id', 'properties.cell', 'properties.agency_id', DB::raw("'0' AS quota_used"),
                    DB::raw("'0' AS image_views"))
                    ->join('locations', 'properties.location_id', '=', 'locations.id')
                    ->join('cities', 'properties.city_id', '=', 'cities.id')
                    ->whereNull('properties.deleted_at')
                    ->whereIn('properties.agency_id', $agent_agencies)
                    ->where('properties.user_id', $user);
                $agent_listings = $status == 'all' ? $agent_listings : $agent_listings->where('status', '=', $status);
                return $agent_listings->where($condition)->unionAll($listings->where($condition));
            }
            //in each case of ceo agent or individual user
            return $listings->where($condition);

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


        if ($purpose === 'all') {
            $all = $this->_listings($status, $user, $condition)->where($condition)->orderBy($sort, $order)->paginate($page);
        }
        if ($purpose === 'sale') {
            $sale = $this->_listings($status, $user, $condition)->where('purpose', '=', 'sale')->where($condition)->orderBy($sort, $order)->paginate($page);
        }
        if ($purpose === 'rent') {
            $rent = $this->_listings($status, $user, $condition)->where('purpose', '=', 'rent')->orderBy($sort, $order)->where($condition)->paginate($page);
        }
        if ($purpose === 'wanted') {
            $wanted = $this->_listings($status, $user, $condition)->where('purpose', '=', 'wanted')->orderBy($sort, $order)->where($condition)->paginate($page);
        }

        return ['all' => $all, 'sale' => $sale, 'rent' => $rent, 'wanted' => $wanted];
    }

    public function listings(string $status, string $purpose, string $user, string $sort, string $order, string $page, Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->getAuthIdentifier();
        }

        $property_count = $this->getPropertyListingCount($user);
        $footer_content = (new FooterController)->footerContent();
        if ($request->has('user-property-id')) {
            $condition = ['properties.id' => $request->input('user-property-id')];
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

                ],
                'recent_properties' => $footer_content[0],
                'footer_agencies' => $footer_content[1]
            ];

            return view('website.pages.listings', $data);
        }
//        else if ($request->has('city')) {
//            $city = (new City)->select('id')->where('name', '=', str_replace('-', ' ', $request->city))->first();
//            $condition = ['properties.city_id' => $city->id];
//            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
//            $data = [
//                'params' => [
//                    'status' => $status,
//                    'purpose' => $purpose,
//                    'user' => 'admin',
//                    'sort' => $sort,
//                    'order' => $order,
//                    'page' => $page,
//                ],
//                'counts' => $property_count,
//                'listings' => [
//                    'all' => $result['all'],
//                    'sale' => $result['sale'],
//                    'rent' => $result['rent'],
//                    'wanted' => $result['wanted'],
//                    'basic' => $result['basic'],
//                    'silver' => $result['silver'],
//                    'bronze' => $result['bronze'],
//                    'golden' => $result['golden'],
//                    'platinum' => $result['platinum'],
//                ],
//            ];
//
//            return view('website.admin-pages.listings', $data);
//        }
//        else if ($request->has('id')) {
//            $condition = ['properties.id' => $request->input('id')];
//            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
//            $data = [
//                'params' => [
//                    'status' => $status,
//                    'purpose' => $purpose,
//                    'user' => 'admin',
//                    'sort' => $sort,
//                    'order' => $order,
//                    'page' => $page,
//                ],
//                'counts' => $property_count,
//                'listings' => [
//                    'all' => $result['all'],
//                    'sale' => $result['sale'],
//                    'rent' => $result['rent'],
//                    'wanted' => $result['wanted'],
//                    'basic' => $result['basic'],
//                    'silver' => $result['silver'],
//                    'bronze' => $result['bronze'],
//                    'golden' => $result['golden'],
//                    'platinum' => $result['platinum'],
//                ],
//            ];
//
//            return view('website.admin-pages.listings', $data);
//        }
//        else if ($request->has('reference')) {
//            $condition = ['properties.reference' => $request->input('reference')];
//            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
//            $data = [
//                'params' => [
//                    'status' => $status,
//                    'purpose' => $purpose,
//                    'user' => $user,
//                    'sort' => $sort,
//                    'order' => $order,
//                    'page' => $page,
//                ],
//                'counts' => $property_count,
//                'listings' => [
//                    'all' => $result['all'],
//                    'sale' => $result['sale'],
//                    'rent' => $result['rent'],
//                    'wanted' => $result['wanted'],
//                    'basic' => $result['basic'],
//                    'silver' => $result['silver'],
//                    'bronze' => $result['bronze'],
//                    'golden' => $result['golden'],
//                    'platinum' => $result['platinum'],
//                ],
//                'recent_properties' => $footer_content[0],
//                'footer_agencies' => $footer_content[1]
//            ];
//            if ($data['listings']['all'])
//                return redirect()->back()->withInput()->with('error', 'Property not found.');
//
//            return view('website.pages.listings', $data);
//        }

//        // TODO: implement code where status is rejected_images or rejected_videos, remove after
//        if (in_array($status, ['rejected_images', 'rejected_videos'])) {
//            return abort(404, 'Missing implementation');
//        }

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

//        if (Auth::guard('admin')->user()) {
//            $condition = [];
//            $result = $this->_getPropertiesByPurpose($purpose, $condition, $status, $order, $user, $sort, $page);
//
//            $data = [
//                'params' => [
//                    'status' => $status,
//                    'purpose' => $purpose,
//                    'user' => $user,
//                    'sort' => $sort,
//                    'order' => $order,
//                    'page' => $page,
//                ],
//                'counts' => $property_count,
//                'listings' => [
//                    'all' => $result['all'],
//                    'sale' => $result['sale'],
//                    'rent' => $result['rent'],
//                    'wanted' => $result['wanted'],
//
//                ],
//            ];
//
//            return view('website.admin-pages.listings', $data);
//        }
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
//        if ($user == 1) {
//            $counts = [];
//            foreach (['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold'] as $status) {
//                $counts[$status]['all'] = $this->listingsCount($status, $user)->first()->count;
//                $counts[$status]['sale'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'sale')->first()->count;
//                $counts[$status]['rent'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'rent')->first()->count;
//                $counts[$status]['wanted'] = $this->listingsCount($status, $user)->where('property_purpose', '=', 'wanted')->first()->count;
//
//            }
//            return $counts;
//        } else
//            {
            $counts = [];
            foreach (['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected', 'sold'] as $status) {
//            foreach (['edited'] as $status) {
                $counts[$status]['all'] = $this->userListingsCount($status, $user, 'all');
                $counts[$status]['sale'] = $this->userListingsCount($status, $user, 'sale');
                $counts[$status]['rent'] = $this->userListingsCount($status, $user, 'rent');
                $counts[$status]['wanted'] = $this->userListingsCount($status, $user, 'wanted');
            }
            return $counts;
//        }

    }

    function userListingsCount($status, $user, $purpose)
    {
        $ceo_property_count = 0;
        $condition_1 = [];
        $condition_2 = [];
        if ($purpose == 'all') {
            $condition_1 = ['property_status' => $status, 'user_id' => $user, 'listing_type' => 'basic_listing'];
            $condition_2 = ['property_status' => $status, 'listing_type' => 'basic_listing'];

        } else {
            $condition_1 = ['property_status' => $status, 'user_id' => $user, 'listing_type' => 'basic_listing', 'property_purpose' => $purpose];
            $condition_2 = ['property_status' => $status, 'listing_type' => 'basic_listing', 'property_purpose' => $purpose];

        }

        $individual_count = DB::table('property_count_by_user')
            ->select(DB::raw('sum(individual_count) as count'))
            ->where($condition_1)
            ->where('agency_id', '=', null);
        $individual_count_num = $individual_count->get()->pluck('count')[0];

        $ceo = Agency::where('user_id', '=', $user);
        $ceo_agencies = $ceo->pluck('id')->toArray(); //gives ceo of agency

        $agents = DB::table('agency_users')->where('user_id', $user);
        $agent_agencies = $agents->pluck('agency_id')->toArray(); //gives all agency users
        $ceo_count_num = 0;
        $agent_count_num = 0;
        if (count($ceo_agencies) > 0) {
            $ceo_property_count = DB::table('property_count_by_user')
                ->select(DB::raw('sum(agency_count) as count'))
                ->where('property_status', '=', $status)
                ->whereIn('agency_id', $ceo_agencies);

            $ceo_agency_count = DB::table('property_count_by_user')
                ->select(DB::raw('sum(agency_count) as count'))
                ->where('property_status', '=', $status)
                ->where('user_id', '=', $user)
                ->whereNotIn('agency_id', $ceo_agencies);


            if ($purpose != 'all') {
                $ceo_property_count = $ceo_property_count->where('property_purpose', '=', $purpose);
                $ceo_agency_count = $ceo_agency_count->where('property_purpose', '=', $purpose);
            }

            $ceo_count_num = $ceo_property_count->get()->pluck('count')[0];
            $ceo_agency_count = $ceo_agency_count->get()->pluck('count')[0];
            return $ceo_count_num + $individual_count_num + $ceo_agency_count;
        } else if (count($agent_agencies) > 0) {
            $agent_property_count = DB::table('property_count_by_user')
                ->select(DB::raw('sum(agency_count) as count'))
                ->where('property_status', '=', $status)
                ->where('user_id', '=', $user)
                ->whereIn('agency_id', $agent_agencies);

            if ($purpose != 'all')
                $agent_property_count = $agent_property_count->where('property_purpose', '=', $purpose);

            $agent_property_count = $agent_property_count->get()->pluck('count')[0];
            return $agent_property_count + $individual_count_num;
        } else
            return $individual_count_num;
    }


}
