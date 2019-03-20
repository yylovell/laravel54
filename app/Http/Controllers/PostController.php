<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author yaoyuan
     */
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->paginate(6);

        $posts->load('user');// 预加载优化
        return view("post/index", compact('posts'));
    }

    /**
     *详情
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author yaoyuan
     */
    public function show(Post $post) {

        // 预加载
        $post->load('comments');

        return view("post/show", compact('post'));
    }

    /**
     * 写文章页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author yaoyuan
     */
    public function create() {
        return view("post/create");
    }

    /**
     * 写文章逻辑
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @author yaoyuan
     */
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

    /**
     * 编辑文章页面
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author yaoyuan
     */
    public function edit(Post $post) {
        return view("post/edit", compact("post"));
    }

    /**
     * 编辑文章逻辑
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author yaoyuan
     */
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

    /**
     * 删除文章
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author yaoyuan
     */
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

    /**
     * 评论
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @author yaoyuan
     */
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

    /**
     * 点赞
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @author yaoyuan
     */
    public function zan(Post $post){
        $param = [
          "user_id" => \Auth::id(),
          "post_id" => $post->id
        ];

        Zan::firstOrCreate($param);

        return back();
    }

    /**
     * 取消赞
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @author yaoyuan
     */
    public function unzan(Post $post){
        $post->zan(\Auth::id())->delete();
        return back();
    }

    /**
     * 全文检索
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author yaoyuan
     */
    public function search() {
        $this->validate(request(), [
           'query' => 'required'
        ]);

        $query = request('query');
        $posts = Post::search($query)->paginate(2);

        return view("post/search", compact('posts', 'query'));
    }
}
