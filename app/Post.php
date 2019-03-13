<?php

namespace App;

class Post extends BaseModel
{
    //关联用户表 （多对一）
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    // 关联评论表 （一对多）
    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }
}
