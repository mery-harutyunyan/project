<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function dashboard(){
        return view('users.dashboard');
    }
}
