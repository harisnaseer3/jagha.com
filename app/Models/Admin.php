<?php
namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasRoles;
/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'name', 'email', 'password'
];


/**
* The attributes excluded from the model's JSON form.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];

    public static function getAllAdmins()
    {
        return (new Admin)->select(['id', 'name', 'email'])->with('roles:name')->get();
    }

}
