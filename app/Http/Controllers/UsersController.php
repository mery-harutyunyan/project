<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;

use App\Models\Transactions;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('users.dashboard');
    }

    public function orders()
    {
        $orders = Transactions::select('transactions.*',
            'products.id as product_id',
            'products.name as product_name',
            'images.name as product_photo'
        )
            ->where('user_id', '=', DB::raw(Auth::user()->id))
            ->leftJoin('products', 'products.id', '=', 'transactions.product_id')
            ->leftJoin('images', function ($join) {
                $join->on('images.product_id', '=', 'products.id');
                $join->on('images.is_thumb', '=', DB::raw('1'));
            })
            ->get();

        return view('users.orders', ['orders' => $orders]);
    }
}
