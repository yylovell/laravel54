<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
class AdminUser extends Authenticatable
{
    //避免验证是否记忆
    protected $rememberTokenName = '';

    protected $guarded = [];// 不可注入字段
}
