<?php

namespace App;

class Post extends BaseModel
{
    //
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
