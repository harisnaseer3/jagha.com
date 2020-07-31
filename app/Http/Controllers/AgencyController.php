<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Dashboard\User;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        return view('website.account.agency_create', ['table_name' => 'users', 'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]]);
    }

    public function listingFeaturedPartners()
    {
        $agencies = (new Agency)
            ->select('agencies.title','agencies.id', 'agencies.featured_listing', 'agencies.description', 'agencies.key_listing', 'agencies.featured_listing',
                'agencies.status','agencies.city','agencies.description',  'agencies.phone','agencies.cell', 'agencies.ceo_name AS agent', 'agencies.logo')
//            ->leftjoin('properties', 'properties.agency_id', '=', 'agencies.id')
            ->where('agencies.status', '=', 'verified')
            ->where('agencies.featured_listing', '=', 1)
            ->whereNull('agencies.deleted_at');
        $agencies->orderBy('agencies.created_at', 'DESC');
        $property_types = (new PropertyType)->all();

        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate(10),
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1],

        ];
        return view('website.pages.agency_listing', $data);
    }

    public function listingKeyPartners()
    {
        $agencies = (new Agency)
            ->select('agencies.title','agencies.id', 'agencies.featured_listing', 'agencies.description', 'agencies.key_listing', 'agencies.featured_listing',
                'agencies.status','agencies.city','agencies.description',  'agencies.phone','agencies.cell', 'agencies.ceo_name AS agent', 'agencies.logo')
//            ->leftjoin('properties', 'properties.agency_id', '=', 'agencies.id')
            ->where('agencies.status', '=', 'verified')
            ->where('agencies.key_listing', '=', 1)
            ->whereNull('agencies.deleted_at');
        $agencies->orderBy('agencies.created_at', 'DESC');
        $property_types = (new PropertyType)->all();

        $data = [
            'property_types' => $property_types,
            'agencies' => $agencies->paginate(10),
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

        $validator = Validator::make($request->all(), Agency::$rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors())->with('error', 'Error storing record, Resolve following error(s).');
        }
        try {
            $agency = (new Agency)->Create([
                'user_id' => Auth::user()->getAuthIdentifier(),
                'city' => json_encode($request->input('select_cities')),
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
                $file = $request->file('upload_new_logo');
                $filename = rand(0, 99);
                $extension = 'webp';
                $filenametostore = $filename . time() . '-256x256.' . $extension;
                Storage::put('public/agency_logos/' . $filenametostore, fopen($file, 'r+'));

                $thumbnailpath = public_path('storage/agency_logos/' . $filenametostore);
                $img = Image::make($thumbnailpath)->fit(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 50);
                $img->save($thumbnailpath);

                $agency->logo = $filenametostore;
            }
            if ($request->hasFile('upload_new_picture')) {
                $file = $request->file('upload_new_picture');
                $filename = rand(0, 99);
                $extension = 'webp';
                $filenametostore = $filename . time() . '-256x256.' . $extension;

                Storage::put('public/agency_ceo_images/' . $filenametostore, fopen($file, 'r+'));

                $thumbnailpath = public_path('storage/agency_ceo_images/' . $filenametostore);
                $img = Image::make($thumbnailpath)->fit(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 50);
                $img->save($thumbnailpath);

                $agency->ceo_image = $filenametostore;
            }

            (new AgencyUserController())->store($agency);

            return redirect()->back()->with('success', 'Your information has been saved.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating record. Try again');
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
     * Display the specified resource.
     *
     * @param \App\Models\Agency $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Agency $agency
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Agency $agency)
    {
        if (Auth::user()->hasRole('admin')) {
            return view('website.account.agency',
                ['table_name' => 'users',
                    'agency' => $agency,
                    'recent_properties' => (new FooterController)->footerContent()[0],
                    'footer_agencies' => (new FooterController)->footerContent()[1]]
            );
        }
        $agency_id = DB::table('agency_users')->select('agency_id')->where('user_id', '=', Auth::user()->getAuthIdentifier())->first();
        $agency = (new Agency)->select('*')->where('id', '=', $agency_id->agency_id)->first();
        return view('website.account.agency',
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

            'select_cities' => 'required',
            'company_title' => 'required|string|max:255',
            'description' => 'required|string|max:4096',
            'email' => 'required|email',
            'phone' => 'required|regex:/\+92-\d{2}-\d{7}/',   // +92-51-1234567
            'mobile' => 'nullable|regex:/\+92-3\d{2}-\d{7}/', // +92-300-1234567
            'fax' => 'nullable|regex:/\+92-\d{2}\-\d{7}/',   // +92-21-1234567
            'address' => 'nullable|string',
            'zip_code' => 'nullable|digits:5',
            'country' => 'required|string',
            'upload_new_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
            'name' => 'nullable|string',
            'designation' => 'nullable|string',
            'message' => 'nullable|string',
            'website' => 'required|url',
            'upload_new_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:128',
        ]);

        if ($validator->fails()) {
            return redirect()->route('agencies.edit', $agency)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
        try {
            (new Agency)->updateOrCreate(['id' => $agency->id], [
                'user_id' => Auth::user()->getAuthIdentifier(),
                'city' => json_encode($request->input('select_cities')),
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
                $file = $request->file('upload_new_logo');

                $filename = rand(0, 99);
                $extension = 'webp';
                $filenametostore = $filename . time() . '-256x256.' . $extension;
                Storage::put('public/agency_logos/' . $filenametostore, fopen($file, 'r+'));

                $thumbnailpath = public_path('storage/agency_logos/' . $filenametostore);
                $img = Image::make($thumbnailpath)->fit(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 50);
                $img->save($thumbnailpath);

                $agency->logo = $filenametostore;
            }
            if ($request->hasFile('upload_new_picture')) {
                $file = $request->file('upload_new_picture');
                $filename = rand(0, 99);
                $extension = 'webp';
                $filenametostore = $filename . time() . '-256x256.' . $extension;

                Storage::put('public/agency_ceo_images/' . $filenametostore, fopen($file, 'r+'));

                $thumbnailpath = public_path('storage/agency_ceo_images/' . $filenametostore);
                $img = Image::make($thumbnailpath)->fit(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 50);
                $img->save($thumbnailpath);

                $agency->ceo_image = $filenametostore;
            }

            $agency->save();
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

        return (new Agency)->select('agencies.title', 'agencies.logo', 'agencies.city','agencies.phone', DB::raw('count(properties.agency_id) as sale_count'))
            ->leftJoin('properties', 'properties.agency_id', '=', 'agencies.id')
            ->where('agencies.status', '=', 'verified')->where('agencies.featured_listing', '=', 1)
            ->where('properties.purpose', '=', 'sale')
            ->groupby('agencies.title', 'agencies.logo', 'agencies.city','agencies.phone')->get();
    }

    public function keyAgencies()
    {
        return (new Agency)->select('title', 'logo', 'city', 'phone')
            ->where('status', '=', 'verified')
            ->where('key_listing', '=', 1)->get();

    }

    private function _listings(string $status, string $user)
    {
        // TODO: make migration for handling quota_used and image_views
        $listings = (new Agency)
            ->select('agencies.id', 'agencies.title', 'agencies.address', 'agencies.city', 'agencies.website', 'agencies.phone', 'agencies.created_at AS listed_date')
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
//        dd($this->getAgencyListingCount($user));
//        dd($this->_listings(explode("_", $status)[0], $user)->orderBy($sort, $order)->get());

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


}
