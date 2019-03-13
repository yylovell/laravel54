<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->withCount('comments')->paginate(6);
        return view("post/index", compact('posts'));
    }

    public function show(Post $post) {

        // 预加载
        $post->load('comments');

        return view("post/show", compact('post'));
    }

    public function create() {
        return view("post/create");
    }

    public function store() {
        $this->validate(request(),
            [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10'
            ]
        );

        $user_id = \Auth::id();
        $insert = request(['title', 'content']);
        $insert = array_merge($insert, compact('user_id'));
        $res = Post::create($insert);

        return redirect("/posts");
    }

    public function edit(Post $post) {
        return view("post/edit", compact("post"));
    }
    public function update(Post $post) {
        $this->validate(request(),
            [
                'title' => 'required|string|max:100|min:5',
                'content' => 'required|string|min:10'
            ]
        );

        $this->authorize('update', $post);

        $post->title = request('title');
        $post->content = request('content');
        $post->save();


        return redirect("/posts/{$post->id}");
    }
    public function delete(Post $post) {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect("/posts");
    }

    /**
     * 上传图片
     * @param Request $request
     * @return string
     */
    public function imageUpload(Request $request) {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'. $path);
    }

    public function comment(Post $post) {
        $this->validate(request(),
            [
                'content' => 'required|min:3'
            ]
        );

        $comments = new Comment();
        $comments->user_id = \Auth::id();
        $comments->content = request('content');

        $post->comments()->save($comments);

        return back();

    }
}
