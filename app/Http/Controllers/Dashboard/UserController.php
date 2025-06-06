<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Admin;
use App\Models\Agency;
use App\Models\Dashboard\PropertyRole;
use App\Models\Dashboard\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Mockery\Exception;
use Throwable;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     * @return \Illuminate\Http\Response
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function index()
    {
        return view('user.index', ['table_name' => 'users', 'table_data_values' => User::all()]);
    }

    public function getAllUsers() {
        $users = User::paginate(10); // paginate(10) means 10 users per page
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create', ['table_name' => 'users', 'roles' => PropertyRole::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error inserting record, try again.');
        }
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request['password']);
            $user->is_active = $request->is_active;
            $user->save();
            $user->roles()->sync($request->roles);
            return view('user.index', ['table_name' => 'users', 'table_data_values' => User::all()]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No record inserted !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Dashboard\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }


    public function edit(User $user)
    {
        return view('website.account.profile',
            [
                'user' => Auth::guard('web')->user(),
                'recent_properties' => (new FooterController)->footerContent()[0],
                'footer_agencies' => (new FooterController)->footerContent()[1]
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Dashboard\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function update(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), User::$rules);
        if ($validator->fails()) {
            return redirect()->route('users.edit', $user->id)->withInput()->withErrors($validator->errors())->with('error', 'Error updating record, Resolve following error(s).');
        }
        try {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->cell = $request->mobile;
//            $user->fax = $request->fax;
            $user->address = $request->address;
            $user->zip_code = $request->zip_code;
            $user->country = $request->country;
            if ($request->city != null && $request->country === 'Pakistan') {
                $user->city_name = $request->city;
            }
            if ($request->city_name != null && $request->country != 'Pakistan') {
                $user->city_name = $request->city_name;
            }

//            $user->community_nick = $request->community_nick;
            $user->about_yourself = $request->about_yourself;
            if ($request->hasFile('upload_new_picture')) {
                $error_msg = [];
                if (request()->file('upload_new_picture')->getSize() > 5000000) {
                    $error_msg['image'] = ' image size must be less or equal to 5 MBs';
                }
//                $allowed_height = 256;
//                $allowed_width = 256;
//
//                $width = getimagesize(request()->file('upload_new_picture'))[0];
//                $height = getimagesize(request()->file('upload_new_picture'))[1];
//
//                if ($height < $allowed_height && $width < $allowed_width) {
//                    $error_msg['upload_new_picture'] = 'upload_new_picture has invalid image dimensions';
//                }
                if ($error_msg != null && count($error_msg)) {
                    return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
                }

                $filename = rand(0, 99);
                $extension = 'webp';
                $filenamewithoutext = 'image-' . $filename . time();
                $filenametostoreindb = $filenamewithoutext . '.' . $extension;

                $files = [['width' => 100, 'height' => 100], ['width' => 450, 'height' => 350]];
                foreach ($files as $file) {
                    $updated_path = $filenamewithoutext . '-' . $file['width'] . 'x' . $file['height'] . '.' . $extension;

                    Storage::put('user_images/' . $updated_path, fopen($request->file('upload_new_picture'), 'r+'));
                    $thumbnailpath = ('thumbnails/user_images/' . $updated_path);

                    $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit($file['width'], $file['height'], function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 1);
                    $img->save($thumbnailpath);
                    $user->image = $filenametostoreindb;
                    $img->save($thumbnailpath);
                }
            }
            $user->save();
            return redirect()->route('users.edit', $user->id)->with('success', 'Your information has been saved');
        } catch (\Exception $e) {
//            dd($e->getMessage());
            return redirect()->route('users.edit', $user->id)->withInput()->with('error', 'No record updated !');
        }
    }

    public function destroy(Request $request)
    {
        if (Gate::denies('delete-users')) {
            return redirect(route('users.index'));
        }
        $user = (new User)->find($request->input('record_id'));
        if ($user->exists) {
            try {
                $user->roles()->detach();
                $user->delete();
                return redirect()->route('users.index')->with('success', 'Record deleted successfully');

            } catch (Throwable $e) {
                return redirect()->route('users.index')->with('error', 'Record not found');
            }
        }
        return redirect()->back()->with('error', 'Record not found');
    }

    /**
     * Show the form for editing user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPassword()
    {
        $data = [
            'notifications' => Auth()->user()->unreadNotifications,
            'recent_properties' => (new FooterController)->footerContent()[0],
            'footer_agencies' => (new FooterController)->footerContent()[1]
        ];
        return view('website.account.password', $data);
    }

    /**
     * Show the form for updating user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function updatePassword(Request $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect()->route('user.password.update')->withInput()->with('error', 'Your current password does not matches with the password you provided. Please try again.');
        }

        if (strcmp($request->get('old_password'), $request->get('new_password')) == 0) {
            return redirect()->route('user.password.update')->withInput()->with('New Password cannot be same as your current password. Please choose a different password.');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
//            'new_password' => 'required|string|min:8|same:confirm_new_password',
            'new_password' => ['required', 'string', 'min:8', 'same:confirm_new_password', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],

        ]);

        if ($validator->fails()) {

            return redirect()->route('user.password.update')->withErrors($validator->errors())->with('error', 'Error updating password, Resolve following error(s).');
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        $user_email = $user->email;
        $admin = Admin::getAdminByEmail($user_email);
        if (!empty($admin)) {
            $updated_password = Admin::updateAdminPassword($admin->id, $user->password);

        }

        return redirect()->route('user.password.update')->with('success', 'Your password is updated');
    }
}
