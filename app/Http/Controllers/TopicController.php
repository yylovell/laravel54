<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //

    public function show(Topic $topic){

        $topic = Topic::withCount('postTopics')->find($topic->id);

        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        // 属于我的文章  但是未投稿的
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        return view('topic/show', compact('topic', 'posts', 'myposts'));
    }

    public function submit(Topic $topic){

        $this->validate(request(), [
           'post_ids' => 'required|array'
        ]);

        $post_ids = request('post_ids');

        $topic_id = $topic->id;

        foreach ($post_ids as $post_id){
            \App\PostTopic::firstOrCreate(compact('topic_id', 'post_id'));
        }

        return back();
    }
}
