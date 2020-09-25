<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class PropertyRole extends Model
{
    use SoftDeletes;

    public $table = 'property_roles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required|string|unique:App\Models\Dashboard\Role,name|max:255',
    ];

    public $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Dashboard\User');
    }
}
