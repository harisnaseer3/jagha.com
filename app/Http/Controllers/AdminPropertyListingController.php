<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminPropertyListingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    private function listingsCount($status, $user, $purpose)
    {
        if ($purpose == 'all') {
            return DB::table('property_count_for_admin')
                ->select(DB::raw('sum(property_count) as count'))
                ->where('property_status', '=', $status)->first()->count;
        } else {

            return DB::table('property_count_for_admin')
                ->select('property_count AS count')
                ->where('property_status', $status)->where('property_purpose', $purpose)
                ->first()->count;
        }

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

        if ($status == 'all') {
            return $listings;
        } else {
            return $listings->where('status', '=', $status);

        }
    }

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
        if (Auth::guard('admin')->check()) {
            $user = 1;
        }

        $property_count = $this->getPropertyListingCount($user);

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

                ],
            ];

            return view('website.admin-pages.listings', $data);
        } else if ($request->has('id')) {
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

                ],
            ];

            return view('website.admin-pages.listings', $data);
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

            ],
        ];

        return view('website.admin-pages.listings', $data);
    }


    public
    function getPropertyListingCount(string $user)
    {
        $counts = [];
        foreach (['active', 'edited', 'pending', 'expired', 'deleted', 'rejected', 'sold'] as $status) {

            $counts[$status]['all'] = $this->listingsCount($status, $user, 'all');
            $counts[$status]['sale'] = $this->listingsCount($status, $user, 'sale');
            $counts[$status]['rent'] = $this->listingsCount($status, $user, 'rent');
            $counts[$status]['wanted'] = $this->listingsCount($status, $user, 'wanted');

        }
        return $counts;

    }
}
