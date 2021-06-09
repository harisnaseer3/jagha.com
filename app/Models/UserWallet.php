<?php

namespace App\Models;

use App\Models\Dashboard\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin Builder
 */
class UserWallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'current_credit'];
    protected $table = 'user_wallet';

    public function getCurrentCredit($user_id = null)
    {
        if (Auth::user() == null) {
            $data = $this->select('current_credit')->where('user_id', $user_id)->first();
        } else
            $data = $this->select('current_credit')->where('user_id', Auth::user()->getAuthIdentifier())->first();

        if ($data)
            return $data->current_credit;
        else
            return 0;
    }

    public function getUserWallet($user)
    {
        return $this->where('user_id', $user)->first();
    }


}
