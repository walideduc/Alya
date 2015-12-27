<?php

namespace Alyya\Http\Controllers;

use Illuminate\Http\Request;

use Alyya\Http\Requests;
use Alyya\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function profile(){
        return view('user.index');
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
