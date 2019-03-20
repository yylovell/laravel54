<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
class AdminUser extends Authenticatable
{
    //避免验证是否记忆
    protected $rememberTokenName = '';

    protected $guarded = [];// 不可注入字段

    /*
     * 一个用户有哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    /*
     * 是否有某个角色
     */
    public function isInRoles($roles)
    {
        return !! $roles->intersect($this->roles)->count();
    }

    /*
     * 是否有权限
     */
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission->roles);
    }

    /*
     * 给用户分配角色
     */
    public function assignRole($role)
    {
        //$role = \App\AdminRole::where('name', $roleName)->first();
        return $this->roles()->save($role);
    }

    /*
     * 删除user和role的关联
     */
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }
}
