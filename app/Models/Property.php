<?php

namespace App\Models;

use App\Models\Dashboard\City;
use App\Models\Dashboard\Location;
use App\Models\Dashboard\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @mixin Builder
 */
class Property extends Model
{
    use SoftDeletes;

    public $table = 'properties';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    protected $casts = [
        'listed_date' => 'date',
        'premium_listing' => 'boolean',
        'super_hot_listing' => 'boolean',
        'hot_listing' => 'boolean',
        'magazine_listing' => 'boolean',
        'is_active' => 'boolean',
    ];


    public $fillable = [
        'reference',
        'user_id',
        'city_id',
        'location_id',
        'purpose',
        'sub_purpose',
        'type',
        'sub_type',
        'title',
        'description',
        'price',
        'call_for_inquiry',
        'land_area',
        'area_unit',
        'area_in_sqft',
        'area_in_sqyd',
        'area_in_sqm',
        'area_in_marla',
        'area_in_new_marla',
        'area_in_new_kanal',
        'area_in_kanal',
        'bedrooms',
        'bathrooms',
        'latitude',
        'longitude',
        'features',
        'premium_listing',
        'super_hot_listing',
        'hot_listing',
        'magazine_listing',
        'contact_person',
        'phone',
        'cell',
        'fax',
        'email',
        'views',
        'visits',
        'click_through_rate',
        'status'
    ];
    public static $rules = [
        'city' => 'required',
        'location' => 'required',
        'purpose' => 'required',
        'property_type' => 'required',
        'property_subtype-*' => 'required',
        'property_title' => 'required|max:225',
        'description' => 'required|max:4096',
        'all_inclusive_price' => 'nullable|numeric|max:99999999999|min:1000',
        'call_for_price_inquiry' => 'numeric',
        'land_area' => 'required|numeric',
        'unit' => 'required',
        'image.*' => 'image|mimes:jpeg,png,jpg|max:256',
        'floor_plans.*' => 'image|mimes:jpeg,png,jpg|max:256',
        'phone' => 'nullable|regex:/\+92-\d{2}\d{7}/', // +92-511234567
        'mobile' => 'nullable|regex:/\+92-3\d{2}\d{7}/', // +92-3001234567
        'fax' => 'nullable|regex:/\+92-\d{2}\\d{7}/', // +92-211234567
        'contact_person' => 'required|max:225',
        'contact_email' => 'required|email',
        'video_link' => 'nullable|url'
    ];

    /**
     * @var \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function floor_plans()
    {
        return $this->hasMany(FloorPlan::class);
    }

    public function getPriceAttribute($price)
    {
        return number_format($price);
    }

    public function getListedDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(Favorite::class)->withTimestamps();

    }

    public function property_detail_path($location = null)
    {
        if ($location != null) {
//            return url("/properties/{$this->id}-" . Str::slug($location) . '-' . Str::slug($this->title) . '-' . $this->reference);
            return url("/properties/" . Str::slug($location) . '-' . Str::slug($this->title) . '-' . $this->reference . '_' . $this->id);

        } else
            return url("/properties/" . Str::slug($this->location) . '-' . Str::slug($this->title) . '-' . $this->reference . '_' . $this->id);

//        return url("/properties/{$this->id}-" . Str::slug($this->location) . '-' . Str::slug($this->title) . '-' . $this->reference);
    }
}
