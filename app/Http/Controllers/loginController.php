<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\user;

class loginController extends Controller
{

    function index(){
        if(session()->has('userID'))
            return redirect(url('loggedIn'));
        else
            return view('login');
    }

    function logIn(request $r){
        $user = user::where('login', $r->login) -> first();

        if($user && Hash::check($r->password, $user->password)){
            session()->put('userID', $user->id);
            return session()->get('userID');
        }
        else{
            $info['type'] = 'danger';
            $info['title'] = 'Account not found!';
            $info['desc'] = 'Login or/and password is/are wrong!';
            return view('login', compact('info'));
        }
    }

}
