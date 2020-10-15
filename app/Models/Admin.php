<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
        $condition = ['is_super' => '0'];
        return (new Admin)->select(['id', 'name', 'email', 'is_active'])->where($condition)->with('roles:name')->get();
    }

    public static function getAdminById($id)
    {
        return (new Admin)->select(['id', 'name', 'email'])->findOrFail($id);
    }

    public static function getAdminByEmail($email)
    {
        return (new Admin)->where('email', $email)->first();
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

    public static function updateAdminPassword($id, $password)
    {
      return  DB::table('admins')
            ->where('id',$id)
            ->update(['password' => $password]);


    }

    public static function destroy($id)
    {
        $current_admin = (new Admin)->find($id);
        try {
            if ($current_admin->is_active === '1') {
                $current_admin->is_active = '0';
            } elseif ($current_admin->is_active === '0') {
                $current_admin->is_active = '1';
            }

            $current_admin->update();
            return $current_admin->is_active;
        } catch (\Exception $e) {
        }
    }

    public function getAdminsByRole($role)
    {
        return (new Admin)
            ->whereHas('roles', function (Builder $query) use ($role) {
                return $query->where('name', $role);
            })
            ->get()
            ->pluck('name', 'email')
            ->toArray();
    }

    public function getPermissionsByRole($role_name)
    {
        return Role::findByName($role_name)->permissions->map->only('name');
    }


}
