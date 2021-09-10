<?php

namespace App\Models\Dashboard;

use App\Models\Admin;
use App\Models\Agency;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyApiEmail;
/**
 * @mixin Builder
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'roles', 'cell'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string', // +92-511234567
        'mobile' => 'required', // +92-3001234567
        'address' => 'nullable|string',
        'zip_code' => 'nullable|digits:5',
        'country' => 'required|string',
        'community_string' => 'nullable|string',
        'about_yourself' => 'nullable|string|max:4096',
        'upload_new_picture.*' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
        'city_name' => 'nullable|string|max:255'
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Dashboard\PropertyRole');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Property')->using('App\Favorite')->withTimestamps();
    }

    public static function findUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();

    }

//    public function agencies()
    public function agencies()
    {
        return $this->hasMany(Agency::class, 'user_id');
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public static function getAllUsers()
    {

        return (new User)->select(['id', 'name', 'email', 'is_active', 'phone', 'cell', 'fax', 'address', 'zip_code', 'country', 'community_nick', 'about_yourself'])->get();
    }

    public static function getUserByEmail($email)
    {
        return (new User)->where('email', $email)->first();
    }

    public static function getUserById($id)
    {
        return (new User)->where('id', $id)->first();
    }

    public static function getUserName($id)
    {
        return (new User)->where('id', $id)->pluck('name')->first();
    }



    public static function destroyUser($id)
    {
        $current_user = (new User)->find($id);
        try {
            if ($current_user->is_active === '1') {
                $current_user->is_active = '0';
            } elseif ($current_user->is_active === '0') {
                $current_user->is_active = '1';
            }

            $current_user->update();
            return $current_user->is_active;
        } catch (\Exception $e) {
        }
    }


    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public static function createUser($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->cell = $data['mobile'];
        $user->phone = $data['phone'];
        $user->country = $data['country'];
        $user->password = Hash::make($data['account_password']);
        $user->address = $data['address'];
        $user->zip_code = $data['zip_code'];
        $user->city_name = $data['city_name'];
        $user->save();
        return $user;

    }
    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }
}
