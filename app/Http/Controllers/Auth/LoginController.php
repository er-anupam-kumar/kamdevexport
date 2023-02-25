<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Auth;
use Session;
use Cache;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    public function __construct(){
        $this->url = '/';
    }

    public function index()
    {
        // try {
        if (Auth::user() &&  Auth::user()->type === 'Admin') {
            return redirect('/admin');
        }
        
        if (Auth::user() &&  Auth::user()->type === 'Customer') {
            return redirect('/');
        }

        return view('auth.login');
        // } catch (Exception $e) {
        //     return abort(404);
        // }
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials)){
            return response([
                'success'=> false,
                'message'=> 'Invalid credentials',
            ],400);
        }

        $user = Auth::user();
        
        if($user->status == '0'){
            Auth::logout();
            return response([
                'success'=> false,
                'message'=> 'Your account approval is in progress. Will notify you once it is approved.',
            ],400);
        }

        if($user->status == '2'){
            Auth::logout();
            return response([
                'success'=> false,
                'message'=> 'Your account is Blocked. Please contact to Administrator.',
            ],400);
        }

        if($user->status == '3'){
            Auth::logout();
            return response([
                'success'=> false,
                'message'=> 'Your account is Inactive. Please contact to Administrator.',
            ],400);
        }

        if($user->type === 'Admin') {
            $this->url = url('/admin');
        }

        if($user->type === 'Customer') {
            $this->url = url('/');
        }

        return response([
            'success'=> true,
            'message'=> 'You are successfully logged in. Please wait.',
            'url'=> $this->url
        ],200);
    }

    public function logout()
    {
        Session::flush();
        Cache::flush();
        return redirect('login');
    }
}
