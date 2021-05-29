<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class UserWallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'current_credit'];
    protected $table = 'user_wallet';


}
