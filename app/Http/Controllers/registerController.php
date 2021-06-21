<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\user;

class registerController extends Controller
{
    function index(){
        if(session()->has('userID'))
            return redirect(url('loggedIn'));
        else
            return view('register');
    }

    function signup(request $r){
        $r -> validate([
            'login' => "min:3|max:15|required|unique:users",
            'e-mail' => "email:rfc,dns|unique:users",
            'password'  => 'min:3|max:50',
            'password2' => 'same:password'
        ]);

        $temp = $r -> all();
        $temp['password'] = Hash::make($r->password);
        unset($temp['password2']);

        user::create($temp);

        $info['title'] = 'Register successful';
        $info['desc'] = 'You can log in now!';

        return(view('login', compact('info')));
    }
}