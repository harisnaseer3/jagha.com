<?php

namespace App\Models;

use App\Models\Dashboard\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @mixin Builder
 */
class Agency extends Model
{
    use SoftDeletes, Notifiable;


    public $table = 'agencies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'city_id', 'title', 'description', 'phone', 'zip_code', 'cell', 'fax', 'address', 'country', 'email', 'website', 'ceo_name', 'ceo_designation',
        'ceo_message', 'ceo_image', 'status', 'featured_listing', 'key_listing', 'rejection_reason', 'reviewed_by'];
    public static $rules = [
        'city' => 'required|string',
        'company_title' => 'required|string|max:255',
        'description' => 'required|string|max:4096',
//        'email' => 'required|email|unique:agencies',
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
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Dashboard\User');
    }

    public function images()
    {
        return $this->hasMany('App\Models\AgencyImage');

    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
