<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Products;
use App\Models\Images;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return string
     */
    public function shop()
    {
        $products = Products::where('products.count', '>', 0)
            ->leftJoin('images', function ($join) {
                $join->on('images.product_id', '=', 'products.id');
                $join->on('images.is_thumb', '=', DB::raw('1'));
            })
            ->select('products.*', 'images.name as photo')
            ->paginate(2);

        return view('shop.shop', ['products' => $products]);
    }

    public function viewProduct($id)
    {
        if (!$id) {
            return redirect('dashboard');
        }

        $product = Products::where('id', '=', $id)->first();

        if (!$product) {
            return redirect('dashboard');
        }

        $images = Images::where('product_id', '=', $id)->get()->toArray();

        return view('shop.product', [
            'product' => $product,
            'images' => $images,
        ]);

    }
}
