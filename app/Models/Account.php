<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'message_signature',
        'email_notification',
        'newsletter',
        'automated_reports',
        'email_format',
        'default_currency',
        'default_area_unit',
        'default_language',
        'sms_notification',
    ];

    public static $rules = [
        'message_signature' => 'nullable|string',
        'email_notification' => 'required',
        'newsletter' => 'required',
        'automated_reports' => 'required',
//        'email_format' => 'required',
        'default_currency' => 'required',
        'default_area_unit' => 'required',
        'default_language' => 'required',
        'sms_notification' => 'required',
    ];

}
