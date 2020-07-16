<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Agency extends Model
{
    use SoftDeletes;

    public $table = 'agencies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id','city', 'title', 'description', 'phone', 'zip_code', 'cell', 'fax', 'address', 'country', 'email', 'website', 'ceo_name', 'ceo_designation',
        'ceo_message','ceo_image','status','featured_listing','key_listing'
    ];
    public static $rules = [

        'select_cities' => 'required',
        'company_title' => 'required|string|max:255',
        'description' => 'required|string|max:4096',
        'email' => 'required|email|unique:agencies',
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
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Dashboard\User');
    }

    public function images()
    {
        return $this->hasMany('App\Models\AgencyImage');

    }
}
