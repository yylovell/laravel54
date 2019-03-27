<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    public function index() {
        return view('login/index');

        //return view('welcome');
    }

    //
    public function login() {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
            'is_remember' => 'integer'
        ]);

        $user = request(['email', 'password']);

        if (\Auth::attempt($user,boolval(request('is_remember')))) {
            return redirect("/posts");
        }

        return \Redirect::back()->withErrors("邮箱密码不匹配");

    }

    public function logout() {
        \Auth::logout();
        return redirect("/login");
    }
}
