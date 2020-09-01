<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Models\Agency;
use App\Models\Dashboard\Role;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create', ['table_name' => 'users', 'roles' => Role::all()]);
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
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Dashboard\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(User $user)
    {
//        if (Gate::denies('edit-users')) {
//            return redirect(route('users.index'));
//        }
//        $user_roles = User::find($user->id)->roles()->get(['name'])->all();
//        $roles = [];
//        foreach ($user_roles as $role) $roles[] = $role->getAttributes()['name'];
//        $user->user_roles = $roles;
//        return view('user.edit', ['table_name' => 'users', 'user' => $user, 'roles' => Role::all()]);
        return view('website.account.profile',
            ['user' => $user,
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
            $user->phone = $request->phone;
            $user->cell = $request->cell;
            $user->fax = $request->fax;
            $user->address = $request->address;
            $user->zip_code = $request->zip_code;
            $user->country = $request->country;
            $user->community_nick = $request->community_nick;
            $user->about_yourself = $request->about_yourself;
            if ($request->hasFile('upload_new_picture')) {
                $error_msg = [];
                $allowed_height = 256;
                $allowed_width = 256;

                $width = getimagesize(request()->file('upload_new_picture'))[0];
                $height = getimagesize(request()->file('upload_new_picture'))[1];

                if ($height < $allowed_height && $width < $allowed_width) {
                    $error_msg['upload_new_picture'] = 'upload_new_picture has invalid image dimensions';
                }
                if (count($error_msg)) {
                    return redirect()->back()->withErrors($error_msg)->withInput()->with('error', 'Error storing record, Resolve following error(s).');
                }

                $file = $request->file('upload_new_picture');
                $filename = rand(0, 99);

                $extension = 'webp';
                $filenametostore = $filename . '-' . time() . '-256x256.' . $extension;
                $thumbnailpath = public_path('storage/user_profile_images/' . $filenametostore);

                Storage::put('public/user_profile_images/' . $filenametostore, fopen($file, 'r+'));

                $img = \Intervention\Image\Facades\Image::make($thumbnailpath)->fit(256, 256, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('webp', 1);

                $img->save($thumbnailpath);

                $user->image = $filenametostore;
            }
            $user->save();
            return redirect()->route('users.edit', $user->id)->with('success', 'Your information has been saved');
        } catch (\Exception $e) {
            dd($e);
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
            'recent_properties' => (new FooterController)->footerContent()[0], 'footer_agencies' => (new FooterController)->footerContent()[1]
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
            'new_password' => ['required', 'string', 'min:8', 'same:confirm_new_password','regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'],

        ]);

        if ($validator->fails()) {
            return redirect()->route('user.password.update')->withErrors($validator->errors())->with('error', 'Error updating password, Resolve following error(s).');
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new_password'));
        $user->save();
        return redirect()->route('user.password.update')->with('success', 'Your password is updated');
    }
}
