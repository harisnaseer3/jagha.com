<?php

namespace App\Models\Dashboard;

use App\Models\Agency;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'roles'
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
        'phone' => 'required|regex:/\+92-\d{2}\d{7}/',   // +92-511234567
        'mobile' => 'nullable|regex:/\+92-3\d{2}\d{7}/', // +92-3001234567
        'fax' => 'nullable|regex:/\+92-\d{2}\\d{7}/',   // +92-211234567
        'address' => 'nullable|string',
        'zip_code' => 'nullable|digits:5',
        'country' => 'required|string',
        'community_string' => 'nullable|string',
        'about_yourself' => 'nullable|string',
        'upload_new_picture.*' => 'nullable|image|mimes:jpeg,png,jpg|max:128',
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
        return $this->belongsToMany('App\Models\Dashboard\Role');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Property')->using('App\Favorite')->withTimestamps();
    }

//    public function agencies()
    public function agency()
    {
        return $this->belongsTo(Agency::class);
//        return $this->belongsToMany('App\Models\Agency', 'agency_users');
    }

    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}
