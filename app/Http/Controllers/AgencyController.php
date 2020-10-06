<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use App\Models\Property;
use App\Models\PropertyType;
use App\Notifications\AgencyRejectionMail;
use App\Notifications\AgencyStatusChange;
use App\Notifications\PropertyStatusChange;
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
            ->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');

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

    public function show(string $city, string $slug, string $agency)
    {
        $properties = (new Property)
            ->select('properties.reference', 'properties.agency_id', 'properties.id', 'properties.purpose', 'properties.sub_purpose', 'properties.sub_type', 'properties.type', 'properties.title', 'properties.description',
                'properties.price', 'properties.land_area', 'properties.area_unit', 'properties.bedrooms', 'properties.bathrooms', 'properties.features', 'properties.premium_listing',
                'properties.super_hot_listing', 'properties.hot_listing', 'properties.magazine_listing', 'properties.contact_person', 'properties.phone', 'properties.cell',
                'properties.fax', 'properties.email', 'properties.favorites', 'properties.views', 'properties.status', 'properties.created_at', 'properties.updated_at', 'f.user_id AS user_favorite', 'locations.name AS location',
                'cities.name AS city', 'p.name AS image',
                'agencies.title AS agency', 'agencies.featured_listing', 'agencies.key_listing', 'agencies.logo AS logo', 'agencies.created_at AS agency_created_at',
                'agencies.description AS agency_description', 'agencies.status AS agency_status', 'agencies.phone AS agency_phone', 'agencies.ceo_name AS agent',
                'property_count_by_agencies.property_count AS agency_property_count', 'users.community_nick AS user_nick_name', 'users.name AS user_name')
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
            ->leftJoin('property_count_by_agencies', 'agencies.id', '=', 'property_count_by_agencies.agency_id')
            ->join('users', 'properties.user_id', '=', 'users.id')
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
        $counts = $this->getAgencyListingCount(Auth::user()->getAuthIdentifier());

        if (Auth::guard('admin')->user()) {
            return view('website.admin-pages.agency_profile.agency_create',
                ['table_name' => 'users',
                    'counts' => $counts,
                    'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
        } else

            return view('website.agency_profile.agency_create',

                ['table_name' => 'users',
                    'counts' => $counts,
                    'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
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

        $agencies = $agencies->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');

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
            ->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');
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
        $agencies = $agencies->orderBy('agencies.created_at', $sort === 'newest' ? 'DESC' : 'ASC');

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
            $user_id = '';
            if ($request->has('user_id')) {
                $user_id = $request->input('user_id');
            }

            $agency = (new Agency)->Create([
                'user_id' => $user_id != '' ? $user_id : Auth::user()->getAuthIdentifier(),
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
                'ceo_message' => $request->input('about_CEO'),
                'status' => $request->has('status') ? $request->input('status') : 'pending',
                'reviewed_by' => $request->has('status') && Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : null

            ]);
            if ($request->hasFile('upload_new_logo')) {
                $this->storeAgencyLogo($request->file('upload_new_logo'), $agency);
            }
            if ($request->hasFile('upload_new_picture')) {
                $this->storeAgencyLogo($request->file('upload_new_picture'), $agency);
            }
            (new AgencyUserController())->store($agency, $user_id);

            (new AgencyCityController())->store($agency);

            if ($request->has('status') && $request->input('status') === 'verified') {
                $this->insertIntoCounterTable();
            }

//            return redirect()->route('agencies.update', $agency)->with('success', 'Your information has been saved.');
            if (Auth::guard('admin')->user()) {
                (new AgencyLogController())->store($agency);
                return redirect()->route('admin.agencies.listings', [
                    'status' => 'pending_agencies',
                    'purpose' => 'all',
                    'user' => Auth::guard('admin')->user()->getAuthIdentifier(),
                    'sort' => 'id',
                    'order' => 'asc',
                    'page' => 10,
                ])->with('success', 'Agency profile has been saved.');
            } else
                return redirect()->route('agencies.listings', [
                    'status' => 'pending_agencies',
                    'purpose' => 'all',
                    'user' => Auth::user()->getAuthIdentifier(),
                    'sort' => 'id',
                    'order' => 'asc',
                    'page' => 10,
                ])->with('success', 'Agency profile has been saved.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error storing record. Try again');
        }
    }

    public function edit(Agency $agency)
    {
        $city = $agency->city->name;
        $agency->city = $city;

        if (Auth::guard('admin')->user()) {
            $counts = $this->getAgencyListingCount(Auth::guard('admin')->user()->getAuthIdentifier());
            return view('website.admin-pages.agency_profile.agency',
                ['table_name' => 'users',
                    'counts' => $counts,
                    'agency' => $agency
                ]
            );
        } else {
            $counts = $this->getAgencyListingCount(Auth::user()->getAuthIdentifier());
            return view('website.agency_profile.agency',

                ['table_name' => 'users',
                    'counts' => $counts,
                    'agency' => $agency,
                    'recent_properties' => (new FooterController)->footerContent()[0],
                    'footer_agencies' => (new FooterController)->footerContent()[1]]
            );
        }
    }

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
            'upload_new_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('agencies.edit', $agency)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }

        if ($request->has('status') && $request->input('status') == 'rejected') {
            if ($request->has('rejection_reason') && $request->input('rejection_reason') == '') {
                return redirect()->back()->withInput()->with('error', 'Please specify the reason of rejection.');
            } else {
//                TODO: send an email to property user with reason of rejection
                $reason = $request->input('rejection_reason');
                $agency_user = User::where('id', '=', $agency->user_id)->first();
                $agency_user->notify(new AgencyRejectionMail($agency, $reason));
            }
        }
        try {
            $status_before_update = $agency->status;
            $city = (new City)->select('id', 'name')->where('name', '=', str_replace('_', ' ', $request->input('city')))->first();


            (new Agency)::where('id', $agency->id)->update([
//                'user_id' => Auth::user()->getAuthIdentifier(),
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
                'status' => $request->has('status') ? $request->input('status') : 'pending',
                'ceo_name' => $request->input('name'),
                'ceo_designation' => $request->input('designation'),
                'ceo_message' => $request->input('about_CEO'),
                'rejection_reason' => $request->has('rejection_reason') ? $request->input('rejection_reason') : null,
                'reviewed_by' => $request->has('status') && Auth::guard('admin')->user() ? Auth::guard('admin')->user()->name : null,

            ]);
            if ($request->hasFile('upload_new_logo')) {
                $this->storeAgencyLogo($request->file('upload_new_logo'), $agency);
            }
            if ($request->hasFile('upload_new_picture')) {
                $this->storeAgencyCeoImage($request->file('upload_new_picture'), $agency);
            }

            if ($status_before_update === 'verified' && in_array($request->input('status'), ['edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected']))
                $this->deleteFromCounterTable();
            if ($request->has('status') && $request->input('status') === 'verified') {
                $this->insertIntoCounterTable();
            }

            $user = User::where('id', '=', $agency->user_id)->first();
            $user->notify(new AgencyStatusChange($agency));
            if (Auth::guard('admin')->user()) {
                (new AgencyLogController())->store($agency);
                return redirect()->route('admin.agencies.listings', [
                    'status' => 'pending_agencies',
                    'purpose' => 'all',
                    'user' => Auth::guard('admin')->user()->getAuthIdentifier(),
                    'sort' => 'id',
                    'order' => 'asc',
                    'page' => 10,
                ])->with('success', 'Agency profile has been updated.');
            } else {
                return redirect()->route('agencies.listings', [
                    'status' => 'pending_agencies',
                    'purpose' => 'all',
                    'user' => Auth::user()->getAuthIdentifier(),
                    'sort' => 'id',
                    'order' => 'asc',
                    'page' => 10,
                ])->with('success', 'Agency profile has been updated.');
            }

        } catch (Throwable $e) {
            return redirect()->route('agencies.edit', $agency->id)->withInput()->with('error', 'Error updating record. Try again');
        }
    }

    public function destroy(Request $request)
    {
        $agency = (new Agency)->where('id', '=', $request->input('record_id'))->first();
        if ($agency->exists) {
            try {
                if (Auth::guard('admin')->user())
                    $agency->reviewed_by = Auth::guard('admin')->user()->name;
                $agency->status = 'deleted';
                $agency->save();

                $user = User::where('id', '=', $agency->user_id)->first();
                $user->notify(new AgencyStatusChange($agency));

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

    public static function getAgencyById($id)
    {
        return (new Agency)->where('id', $id)->first();
    }

    private function _listings(string $status, string $user)
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = (new Agency)
//            ->select('agencies.id', 'agencies.title', 'agencies.address', 'agencies.city', 'agencies.website', 'agencies.phone', 'agencies.created_at AS listed_date')
            ->select('agencies.title', 'agencies.id', 'agencies.description', 'agencies.address', 'agencies.website', 'agencies..key_listing', 'agencies.featured_listing', 'agencies.status',
                'agency_cities.city_id', 'agencies.phone', 'agencies.cell', 'agencies.created_at', 'agencies.reviewed_by', 'agencies.ceo_name AS agent', 'agencies.logo', 'cities.name AS city',
                'agencies.created_at')
            ->join('agency_cities', 'agencies.id', '=', 'agency_cities.agency_id')
            ->join('cities', 'agency_cities.city_id', '=', 'cities.id')
            ->whereNull('agencies.deleted_at');

        // user is admin who can see this listing

        if (!Auth::guard('admin')->user()) {
            if (empty($user)) {
                $user = Auth::user()->getAuthIdentifier();
            } elseif ($user === 'all') {
                // listing of all users of the agency
                $listings->whereIn('properties.user_id', DB::table('agency_users')
                    ->select('agency_users.user_id')
                    ->where('agency_id', '=', DB::table('agencies')
                        ->join('agency_users', 'agencies.id', '=', 'agency_users.agency_id')
                        ->select('agencies.id')
                        ->where('agency_users.user_id', '=', Auth::user()->getAuthIdentifier())->value('agencies.id'))
                    ->pluck('agency_users.user_id'));
            } else {
                if (intval($user) === Auth::user()->getAuthIdentifier()) {
                    // listing of logged in user
                    $listings->where('agencies.user_id', '=', $user);
                } else {
                    $agency_users = DB::table('agency_users')
                        ->select('agency_users.user_id')->where('agency_id', '=', DB::table('agency_users')
                            ->select('agency_id')
                            ->where('agency_users.user_id', '=', Auth::user()->getAuthIdentifier())->value('agency_id'));

                    // check if user is member of the agency
                    if ($agency_users->count() === 0) {
                        return redirect()->back(302)->withInput()->withErrors(['message', 'Invalid user provided.']);
                    }

                    // listing of user who is member of the agency
                    $listings->whereIn('agencies.user_id', $agency_users->get()->toArray());
                }
            }
        }
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


        $all = $this->_listings(explode("_", $status)[0], $user);
        $key = $this->_listings(explode("_", $status)[0], $user)->where('key_listing', true);
        $featured = $this->_listings(explode("_", $status)[0], $user)->where('featured_listing', true);

        if (Auth::guard('admin')->user()) {
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
                    'all' => $all->orderBy($sort, $order)->paginate($page),
                    'key' => $key->orderBy($sort, $order)->paginate($page),
                    'featured' => $featured->orderBy($sort, $order)->paginate($page),
                ]];
            dd('here');
            return view('website.admin-pages.agency.agency_listings', $data);
        } else {
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
                    'all' => $all->orderBy($sort, $order)->paginate($page),
                    'key' => $key->orderBy($sort, $order)->paginate($page),
                    'featured' => $featured->orderBy($sort, $order)->paginate($page),
                ],
                'notifications' => Auth()->user()->unreadNotifications,
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ];
            return view('website.agency.agency_listings', $data);
        }
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

    public function changeAgencyStatus(Request $request)
    {
        if ($request->ajax()) {

            $agency = (new Agency)->WHERE('id', '=', $request->id)->update(['status' => $request->status]);
            if (Auth::guard('admin')->user())
                (new AgencyLogController())->store($agency);

            return response()->json(['status' => 200]);
        } else {
            return "not found";
        }
    }

}
