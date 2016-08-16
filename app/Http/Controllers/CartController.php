<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;

class CartController extends Controller
{
    /**
     * @return string
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cartData = Cart::where('carts.user_id', '=', Auth::user()->id)
            ->select('carts.count as cart_count', 'carts.id as cart_id','images.name as photo', 'products.*')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->leftJoin('images', function ($join) {
                $join->on('images.product_id', '=', 'products.id');
                $join->on('images.is_thumb', '=', DB::raw('1'));
            })
            ->get()
            ->toArray();


        $sum = 0;
        foreach ($cartData as $data) {
            $sum +=  round( $data['price'] * (1 - ($data['discount'] / 100)), 1, PHP_ROUND_HALF_UP) * $data['cart_count'];
        }

        return view('cart.index', ['cartData' => $cartData, 'sum' => $sum]);
    }

    /**
     * Show the form for creating a new cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created cart in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $save = Cart::create(
            array(
                'user_id' => Auth::user()->id,
                'product_id' => $request->product_id,
                'count' => $request->product_count
            ));
        return redirect('/cart');
    }

    /**
     * Display the specified cart.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified cart.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified cart in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified cart from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function updateCount(Request $request)
    {
        $update = Cart::where('id', $request->cart_id)->update([
            'count' => $request->input('count'),
        ]);

        return response()->json(['status' => true, 'message' => 'Count changed!']);
    }
}
