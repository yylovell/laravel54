<?php

namespace App;

use Laravel\Scout\Searchable;

class Post extends BaseModel
{

    use Searchable;

    // 定义索引里面的type
    public function searchableAs()
    {
        return "post";
    }

    // 定义哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

    // 关联用户表 （多对一）
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    // 关联评论表 （一对多）
    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    // 和用户进行关联 （一对一）
    public function zan($user_id){
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    // 关联的所有赞
    public function zans(){
        return $this->hasMany(\App\Zan::class);
    }
}
