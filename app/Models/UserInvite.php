<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin Builder
 */
class UserInvite extends Model
{
    use SoftDeletes;
    use Notifiable;

    public $table = 'user_invites';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'email'
    ];


    public function routeNotificationForMail($notification)
    {
        return $this->email;

        // Return name and email address...
    }
}
