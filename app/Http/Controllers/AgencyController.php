<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Throwable;
use function GuzzleHttp\Promise\all;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        (new MetaTagController())->addMetaTagsOnPartnersListing();

        $normal_agencies = (new Agency)->select(DB::raw('COUNT(agency_cities.city_id) AS agency_count'), 'cities.name AS city')
            ->where('agencies.status', '=', 'verified')
            ->where('agencies.featured_listing', '=', '0')
            ->where('agencies.key_listing', '=', '0')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')->groupBy('cities.name')
            ->orderBy('agency_count', 'DESC')->get();
        $featured_agencies = (new Agency)->select(DB::raw('COUNT(agency_cities.city_id) AS agency_count'), 'cities.name AS city')
            ->where('agencies.status', '=', 'verified')
            ->where('agencies.featured_listing', '=', '1')
            ->where('agencies.key_listing', '=', '0')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')->groupBy('cities.name')
            ->orderBy('agency_count', 'DESC')->get();
        $key_agencies = (new Agency)->select(DB::raw('COUNT(agency_cities.city_id) AS agency_count'), 'cities.name AS city')
            ->where('agencies.status', '=', 'verified')
            ->where('agencies.key_listing', '=', '1')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->groupBy('cities.name')->orderBy('agency_count', 'DESC')->get();
//        dd($normal_agencies);
        $data = [
            'normal_agencies' => $normal_agencies,
            'featured_agencies' => $featured_agencies,
            'key_agencies' => $key_agencies,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
        ];

        return view('website.pages.all_cities_listing_wrt_agency', $data);
    }

    function _listingFrontend()
    {
        return (new Agency)->select('agencies.title', 'agencies.id', 'agencies.description', 'agencies..key_listing', 'agencies.featured_listing', 'agencies.status',
            'agency_cities.city_id', 'agencies.phone', 'agencies.cell', 'agencies.created_at', 'agencies.ceo_name AS agent', 'agencies.logo', 'cities.name AS city',
            'property_count_by_agencies.property_count AS count')
            ->where('agencies.status', '=', 'verified')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->leftJoin('property_count_by_agencies', 'agencies.id', '=', 'property_count_by_agencies.agency_id');
    }

    function _agencyCount()
    {
        return (new Agency)->select(DB::raw('COUNT(agency_cities.city_id) AS agency_count'), 'cities.name AS city')
            ->where('agencies.status', '=', 'verified')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id');
    }

    public function ListingCityAgencies(string $city, Request $request)
    {
//        TODO: change city store method to find city in db
        $city_name = ucwords(str_replace('-', ' ', $city));
        $city_id = City::select('id')->where('name', '=', $city_name)->first();

        $limit = '';
        $sort = '';
        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        $agencies = $this->_listingFrontend()
            ->where('agency_cities.city_id', '=', $city_id->id);

        if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
            $lastPage = ceil((int)$agencies->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }
        $agencies = $agencies->groupBy('agencies.title', 'agencies.id', 'agencies.featured_listing', 'agency_cities.city_id', 'property_count_by_agencies.property_count')
            ->orderBy('agencies.created_at', $sort === 'newest' ? 'ASC' : 'DESC');

        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTagsOnPartnersListing();

        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],
        ];
        return view('website.pages.agency_listing', $data);
    }

//show properties of agency
//TODO: change property method
    public function show(string $city, string $slug, string $agency)
    {
        $properties = (new Property)
            ->select('properties.reference', 'properties.agency_id', 'properties.id', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type', 'properties.type', 'properties.title', 'properties.description',
                'properties.price', 'properties.land_area', 'properties.area_unit', 'properties.bedrooms', 'properties.bathrooms', 'properties.features', 'properties.premium_listing',
                'properties.super_hot_listing', 'properties.hot_listing', 'properties.magazine_listing', 'properties.contact_person', 'properties.phone', 'properties.cell',
                'properties.fax', 'properties.email', 'properties.favorites', 'properties.views', 'properties.status', 'properties.created_at', 'properties.updated_at', 'f.user_id AS user_favorite', 'locations.name AS location',
                'cities.name AS city', 'p.name AS image',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.key_listing', 'agencies.status AS agency_status', 'agencies.phone AS agency_phone', 'agencies.ceo_name AS agent')
            ->join('locations', 'properties.location_id', '=', 'locations.id')
            ->join('cities', 'properties.city_id', '=', 'cities.id')
            ->leftjoin('agencies', 'properties.agency_id', '=', 'agencies.id')
            ->leftJoin('images as p', function ($q) {
                $q->on('properties.id', '=', 'p.property_id')
                    ->on('p.name', '=', DB::raw('(select name from images where images.property_id = properties.id  limit 1 )'));
            })
            ->leftJoin('favorites as f', function ($f) {
                $f->on('properties.id', '=', 'f.property_id')
                    ->where('f.user_id', '=', Auth::user() ? Auth::user()->getAuthIdentifier() : 0);
            })
            ->where('properties.status', '=', 'active')
            ->where('properties.agency_id', '=', $agency)
            ->whereNull('properties.deleted_at');

        $sort = '';
        $limit = '';
        $sort_area = '';
        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';

        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        if (request()->input('area_sort') !== null)
            $sort_area = request()->input('area_sort');


        $properties = (new PropertyController)->sortPropertyListing($sort, $sort_area, $properties);

        if (request()->has('page') && request()->input('page') > ceil($properties->count() / $limit)) {
            $lastPage = ceil((int)$properties->count() / $limit);
            request()->merge(['page' => (int)$lastPage]);
        }
        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTags();

        $data = [
            'params' => ['sort' => $sort],
            'property_types' => $property_types,
            'properties' => $properties->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.property_listing', $data);

    }

    public function create()
    {
        return view('website.agency_profile.agency_create', ['table_name' => 'users', 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    public function listingFeaturedPartners(Request $request)
    {
        $agencies = $this->_listingFrontend()
            ->where('agencies.featured_listing', '=', 1)
            ->whereNull('agencies.deleted_at');

        $agencyCount = $this->_agencyCount()->where('agencies.featured_listing', '=', 1)
            ->groupBy('agency_cities.city_id')->orderBy('agency_count', 'DESC')->get();

        $property_types = (new PropertyType)->all();
        (new MetaTagController())->addMetaTagsOnPartnersListing();


        $limit = '';
        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
            $lastPage = ceil((int)$agencies->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }

        $agencies->orderBy('agencies.created_at', $sort === 'newest' ? 'ASC' : 'DESC');

        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate($limit),
            'agencies_count' => $agencyCount,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.agency_listing', $data);
    }

    function listingPartnersCitywise(string $agency, string $city, Request $request)
    {
        $city_name = ucwords(str_replace('-', ' ', $city));
        $city_id = City::select('id')->where('name', '=', $city_name)->first();
        $limit = '';
        $sort = '';
        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        $agencies = $this->_listingFrontend()
            ->where('agency_cities.city_id', '=', $city_id->id);
        if ($agency === 'featured') $agencies->where('agencies.featured_listing', '=', 1);
        else if ($agency === 'key') $agencies->where('agencies.key_listing', '=', 1);
        else if ($agency === 'other') $agencies->where('agencies.featured_listing', '=', 0)->where('agencies.key_listing', '=', 0);

        if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
            $lastPage = ceil((int)$agencies->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }

        $agencies->groupBy('agencies.title', 'agencies.id', 'agencies.featured_listing', 'agency_cities.city_id', 'property_count_by_agencies.property_count')
            ->orderBy('agencies.created_at', $sort === 'newest' ? 'ASC' : 'DESC');
        (new MetaTagController())->addMetaTagsOnPartnersListing();


        $property_types = (new PropertyType)->all();

        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate($limit),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.agency_listing', $data);
    }

    public function listingKeyPartners(Request $request)
    {
        $agencies = $this->_listingFrontend()
            ->where('agencies.key_listing', '=', 1)
            ->whereNull('agencies.deleted_at');

        $agencyCount = $this->_agencyCount()->where('agencies.key_listing', '=', 1)
            ->groupBy('agency_cities.city_id')->orderBy('agency_count', 'DESC')->get();

        $property_types = (new PropertyType)->all();
        $limit = '';
        $sort = '';
        if (request()->input('limit') !== null)
            $limit = request()->input('limit');
        else
            $limit = '15';
        if (request()->input('sort') !== null)
            $sort = request()->input('sort');
        else
            $sort = 'newest';

        if ($request->has('page') && $request->input('page') > ceil($agencies->count() / $limit)) {
            $lastPage = ceil((int)$agencies->count() / $limit);
            $request->merge(['page' => (int)$lastPage]);
        }
        $agencies = $agencies->orderBy('agencies.created_at', $sort === 'newest' ? 'ASC' : 'DESC');

        (new MetaTagController())->addMetaTagsOnPartnersListing();


        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate($limit),
            'agencies_count' => $agencyCount,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.agency_listing', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    private function _imageValidation($type)
    {
        if ($type == 'upload_new_logo') {
            $error_msg = [];
            $allowed_height = 256;
            $allowed_width = 256;

            $width = getimagesize(request()->file('upload_new_logo'))[0];
            $height = getimagesize(request()->file('upload_new_logo'))[1];
            if ($height < $allowed_height && $width < $allowed_width) {
                $error_msg['upload_new_logo'] = 'upload_new_logo has invalid image dimensions';
            }
            return $error_msg;
        } else if ($type == 'upload_new_picture') {
            $error_msg = [];
            $allowed_height = 256;
            $allowed_width = 256;

            $width = getimagesize(request()->file('upload_new_picture'))[0];
            $height = getimagesize(request()->file('upload_new_picture'))[1];
            if ($height < $allowed_height && $width < $allowed_width) {
                $error_msg['upload_new_picture'] = 'upload_new_picture has invalid image dimensions';
            }
            return $error_msg;
        }
    }

    public function store(Request $request)
    {
        if ($request->hasFile('upload_new_logo')) {
            $error_msg = $this->_imageValidation('upload_new_logo');
            if ($error_msg !== null && count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
            }
        }

        if ($request->hasFile('upload_new_picture')) {
            $error_msg = $this->_imageValidation('upload_new_picture');
            if ($error_msg !== null && count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
            }
        }
        $validator = Validator::make($request->all(), Agency::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', 'Error storing record, Resolve following error(s).');
        }

        try {

            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();
            $agency = (new Agency)->Create([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'city_id' => $city->id,
                'title' => $request->input('company_title'),
                'description' => $request->input('description'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('cell'),
                'fax' => $request->input('fax'),
                'address' => $request->input('address'),
                'zip_code' => $request->input('zip_code'),
                'country' => $request->input('country'),
                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'ceo_name' => $request->input('name'),
                'ceo_designation' => $request->input('designation'),
                'ceo_message' => $request->input('message')
            ]);
            if ($request->hasFile('upload_new_logo')) {
                $this->storeAgencyLogo($request->file('upload_new_logo'), $agency);
            }
            if ($request->hasFile('upload_new_picture')) {
                $this->storeAgencyLogo($request->file('upload_new_picture'), $agency);
            }
            (new AgencyUserController())->store($agency);
            (new AgencyCityController())->store($agency);
            if ($request->has('status') && $request->input('status') === 'active') {
                $this->insertIntoCounterTable();
            }
            return redirect()->back()->with('success', 'Your information has been saved.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error storing record. Try again');
        }
    }

//    call store agency a new when user register himself and agency
    public function newUserStoreAgency(Request $request)
    {
        try {
            $agency = (new Agency)->Create([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'city' => json_encode(explode(',', $request->input('agency-cities'))),
                'title' => $request->input('agency-email'),
                'description' => $request->input('agency-description'),
                'phone' => $request->input('agency-phone'),
                'cell' => $request->input('agency-cell'),
                'fax' => $request->input('agency-fax'),
                'address' => $request->input('agency-address'),
                'zip_code' => $request->input('agency-zip_code'),
                'country' => $request->input('agency-country'),
                'email' => $request->input('agency-email'),
                'website' => $request->input('agency-website'),
            ]);
            (new AgencyUserController())->store($agency);

        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating record of agency, Resolve following error(s).');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Agency $agency
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Agency $agency)
    {
        $city = $agency->city->name;
        $agency->city = $city;

        if (Auth::user()->hasRole('admin')) {
            return view('website.agency_profile.agency',
                ['table_name' => 'users',
                    'agency' => $agency,
                    'recent_properties' => (new FooterController)->footerContent()[0],
                    'footer_agencies' => (new FooterController)->footerContent()[1]]
            );
        }
        $agency_id = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->first();
        $agency = (new Agency)->select('*')->where('id', '=', $agency_id->agency_id)->first();

        return view('website.agency_profile.agency',
            ['table_name' => 'users',
                'agency' => $agency,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]]
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Agency $agency
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        if ($request->hasFile('upload_new_logo')) {
            $error_msg = $this->_imageValidation('upload_new_logo');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
            }
        }

        if ($request->hasFile('upload_new_picture')) {
            $error_msg = $this->_imageValidation('upload_new_picture');
            if (count($error_msg)) {
                return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
            }
        }

        $validator = Validator::make($request->all(), [
            'city' => 'required|string',
            'company_title' => 'required|string|max:255',
            'description' => 'required|string|max:4096',
            'email' => 'required|email',
            'phone' => 'required|regex:/\+92-\d{2}\d{7}/',   // +92-511234567
            'mobile' => 'nullable|regex:/\+92-3\d{2}\d{7}/', // +92-3001234567
            'fax' => 'nullable|regex:/\+92-\d{2}\d{7}/',   // +92-211234567
            'address' => 'nullable|string',
            'zip_code' => 'nullable|digits:5',
            'country' => 'required|string',
            'upload_new_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
            'name' => 'nullable|string',
            'designation' => 'nullable|string',
            'message' => 'nullable|string',
            'website' => 'required|url',
            'upload_new_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('agencies.edit', $agency)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
        try {
            $status_before_update = $agency->status;
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();


            (new Agency)::where('id', $agency->id)->update([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'city_id' => $city->id,
                'title' => $request->input('company_title'),
                'description' => $request->input('description'),
                'phone' => $request->input('phone'),
                'cell' => $request->input('cell'),
                'fax' => $request->input('fax'),
                'address' => $request->input('address'),
                'zip_code' => $request->input('zip_code'),
                'country' => $request->input('country'),
//                'email' => $request->input('email'),
                'website' => $request->input('website'),
                'status' => $request->input('status'),
                'ceo_name' => $request->input('name'),
                'ceo_designation' => $request->input('designation'),
                'ceo_message' => $request->input('message')
            ]);
            if ($request->hasFile('upload_new_logo')) {
                $this->storeAgencyLogo($request->file('upload_new_logo'), $agency);
            }
            if ($request->hasFile('upload_new_picture')) {
                $this->storeAgencyCeoImage($request->file('upload_new_picture'), $agency);
            }
            if ($status_before_update === 'verified' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                $this->deleteFromCounterTable();


            return redirect()->route('agencies.edit', $agency->id)->with('success', 'Your information has been saved.');
        } catch (Throwable $e) {
            return redirect()->route('agencies.edit', $agency->id)->withInput()->with('error', 'Error updating record. Try again');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = Auth::user()->getAuthIdentifier();
        $agency = (new Agency)->where('id', '=', $request->input('record_id'))->first();
        if ($agency->exists) {
            try {
                $agency->status = 'deleted';
                $agency->save();

                return redirect()->back()->with('success', 'Record deleted successfully');
            } catch (Throwable $e) {
                return redirect()->back()->with('error', 'Error deleting record, please try again');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    public function validateFrom(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), Agency::$rules);

            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 201);
            } else
                return response()->json(array(
                    'success' => true,
                ), 200);
        } else {
            return "not found";
        }
    }

    public function FeaturedAgencies()
    {
        return $this->_listingFrontend()
            ->where('agencies.featured_listing', '=', 1)->get();
    }

    public function keyAgencies()
    {
        return $this->_listingFrontend()
            ->where('key_listing', '=', 1)->get();
    }

    private function _listings(string $status, string $user)
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = (new Agency)
//            ->select('agencies.id', 'agencies.title', 'agencies.address', 'agencies.city', 'agencies.website', 'agencies.phone', 'agencies.created_at AS listed_date')
            ->select('agencies.title', 'agencies.id', 'agencies.description', 'agencies..key_listing', 'agencies.featured_listing', 'agencies.status',
                'agency_cities.city_id', 'agencies.phone', 'agencies.cell', 'agencies.created_at', 'agencies.ceo_name AS agent', 'agencies.logo', 'cities.name AS city',
                'agencies.created_at')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->whereNull('agencies.deleted_at');

        // user is admin who can see this listing

        return $listings->where('status', '=', $status);
    }

    public function getAgencyListingCount(string $user)
    {
        $counts = [];
        foreach (['verified', 'pending', 'expired', 'rejected', 'deleted'] as $status) {
            $counts[$status]['all'] = $this->_listings($status, $user)->count();

            if ($status === 'verified') {
                $counts[$status]['key'] = $this->_listings($status, $user)->where('key_listing', true)->count();
                $counts[$status]['featured'] = $this->_listings($status, $user)->where('featured_listing', true)->count();
            }
        }
        return $counts;
    }

    public function listings(string $status, string $purpose, string $user, string $sort, string $order, string $page)
    {
        // listing of status
        $status = strtolower($status);

        if (!in_array($status, ['verified_agencies', 'pending_agencies', 'expired_agencies', 'rejected_agencies', 'deleted_agencies'])) {
            return redirect()->back(302)->withInput()->withErrors(['message', 'Invalid status provided.']);
        }

        // sort by field
        $sort = 'id';

        // order -> ascending or descending
        $order = strtolower($order);
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }
        // pagination
        if (!in_array($page, [10, 15, 30, 50])) {
            $page = 10;
        }
        $data = [
            'params' => [
                'status' => $status,
                'purpose' => $purpose,
                'user' => $user,
                'sort' => $sort,
                'order' => $order,
                'page' => $page,
            ],
            'counts' => $this->getAgencyListingCount($user),
            'listings' => [
                'all' => $this->_listings(explode("_", $status)[0], $user)->orderBy($sort, $order)->paginate($page),
                'key' => $this->_listings(explode("_", $status)[0], $user)->where('key_listing', true)->orderBy($sort, $order)->paginate($page),
                'featured' => $this->_listings(explode("_", $status)[0], $user)->where('featured_listing', true)->orderBy($sort, $order)->paginate($page),
            ],
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
        ];

        return view('website.agency.agency_listings', $data);
    }


    public function storeAgencyLogo($logo, $agency)
    {
        $filename = rand(0, 99);
        $extension = 'webp';
        $filenamewithoutext = 'logo-' . $filename . time();
        $filenametostoreindb = $filenamewithoutext . '.' . $extension;

        $files = [['width' => 100, 'height' => 100], ['width' => 450, 'height' => 350]];
        foreach ($files as $file) {
            $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;

            Storage::put('public/agency_logos/' . $updated_path, fopen($logo, 'r+'));
            $thumbnailpath = ('thumbnails/agency_logos/' . $updated_path);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 1);
            $img->save($thumbnailpath);

            $agency->logo = $filenametostoreindb;
            $agency->save();
        }
    }

    public function storeAgencyCeoImage($logo, $agency)
    {
        $filename = rand(0, 99);
        $extension = 'webp';
        $filenamewithoutext = 'image-' . $filename . time();
        $filenametostoreindb = $filenamewithoutext . '.' . $extension;

        $files = [['width' => 100, 'height' => 100], ['width' => 450, 'height' => 350]];
        foreach ($files as $file) {
            $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;

            Storage::put('public/agency_ceo_images/' . $updated_path, fopen($logo, 'r+'));
            $thumbnailpath = ('thumbnails/agency_ceo_images/' . $updated_path);

            $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 1);
            $img->save($thumbnailpath);

            $agency->ceo_image = $filenametostoreindb;
            $agency->save();
        }
    }

    public function insertIntoCounterTable()
    {
        $property_count = DB::table('properties')->select(DB::raw('COUNT(id) AS property_count'))->where('status', '=', 'active')->get();
        $agency_count = DB::table('agencies')->select(DB::raw('COUNT(id) AS agency_count'))->where('status', '=', 'verified')->get();
        $cities_count = DB::table('cities')->select(DB::raw('COUNT(id) AS city_count'))->get();
        DB::table('total_property_count')->update(['property_count' => $property_count[0]->property_count, 'agency_count' => $agency_count[0]->agency_count, 'city_count' => $cities_count[0]->city_count]);

    }

    public function deleteFromCounterTable()
    {
        $property_count = DB::table('properties')->select(DB::raw('COUNT(id) AS property_count'))->where('status', '=', 'active')->get();
        $agency_count = DB::table('agencies')->select(DB::raw('COUNT(id) AS agency_count'))->where('status', '=', 'verified')->get();
        $cities_count = DB::table('cities')->select(DB::raw('COUNT(id) AS city_count'))->get();
        DB::table('total_property_count')->update(['property_count' => $property_count[0]->property_count, 'agency_count' => $agency_count[0]->agency_count, 'city_count' => $cities_count[0]->city_count]);

    }
}
