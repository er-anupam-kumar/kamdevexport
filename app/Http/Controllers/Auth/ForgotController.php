<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Str;
use EmailProvider;

class ForgotController extends Controller
{

    public function index()
    {
        // try {
        return view('auth.forgot');
        // } catch (Exception $e) {
        //     return abort(404);
        // }
    }

    public function password(ForgotRequest $request){

        $input = $request->all();
        $user  = User::where('email',$input['email'])->first();
        $password = Str::random(6);

        $user->password = bcrypt($password);
        $user->save();

        EmailProvider::sendMail('forgot-password-mail', 
            [   
                'name'      => $user->name,
                'email'     => $user->email,
                'password'  => $password,
            ]
        );

        return response([
            'success'=> true,
            'message'=> 'We have E-mailed a password on your registered email. Please wait.',
            'url'=> url('/login')
        ],200);
    }
}
