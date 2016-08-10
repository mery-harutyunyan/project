<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        Session::flash('note.success', 'Hiiiiiiiiiiiii');

        return view('users.dashboard');
    }


}
