<?php
namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;



/**
 *
 * @mixin Builder
 */
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
        $condition = ['is_active' => '1'];
        $condition += ['is_super' => '0'];
        return (new Admin)->select(['id', 'name', 'email'])->where($condition)->with('roles:name')->get();
    }
    public static function getAdminById($id)
    {
        return (new Admin)->select(['id', 'name', 'email'])->findOrFail($id);
    }
    public static function updateAdmin($object, $id)
    {
        $current_admin = (new Admin)->findOrFail($id);
        if (empty($current_admin)) {
            return null;
        }
        $current_admin->name = $object['name'];
        $current_admin->email = $object['email'];
        $current_admin->update();
        //updating admin role
        $current_admin->syncRoles($object['role']);
    }
    public static function destroy($id)
    {
        $current_admin = (new Admin)->find($id);
        try {
            $current_admin->is_active = '0';
            $current_admin->update();
        } catch (\Exception $e) {
        }
    }


}
