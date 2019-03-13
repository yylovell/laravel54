<?php

namespace App;

class Comment extends BaseModel
{
    //

    //关联文章表 （多对一）
    public function post() {
        return $this->belongsTo('App\Post');
    }

    //关联用户表 （多对一）
    public function user() {
        return $this->belongsTo('App\User');
    }
}
