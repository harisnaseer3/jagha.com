<?php

namespace App\Models;

use App\Models\Dashboard\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @mixin Builder
 */
class SocialGoogleAccount extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

