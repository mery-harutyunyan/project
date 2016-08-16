<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Products;
use App\Models\Images;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('products.index');
    }

    public function data()
    {

        $products = Products::select(['id', 'name', 'count', 'created_at', 'updated_at']);

        return Datatables::of($products)
            ->addColumn('action', function ($product) {
                return view('products.action', ['product' => $product]);
            })
            ->editColumn('created_at', ' {{ date("F j, Y, g:i a", strtotime($created_at))}}')
            ->editColumn('updated_at', ' {{ date("F j, Y, g:i a", strtotime($updated_at))}}')
            ->make();
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProductRequest $request)
    {
        $product = Products::create($request->all());

        if ($product->id) {
            $picture = '';
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                $firstFile = true;
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $picture = md5(microtime()) . '.' . $extension;
                    $destinationPath = base_path() . '\public\img\products';
                    $file->move($destinationPath, $picture);

                    if ($firstFile) {
                        $data = array(
                            'product_id' => $product->id,
                            'name' => $picture,
                            'is_thumb' => 1
                        );
                    } else {
                        $data = array(
                            'product_id' => $product->id,
                            'name' => $picture,
                            'is_thumb' => 0
                        );
                    }

                    $images = Images::create($data);
                    $firstFile = false;
                }
            }

            Session::flash('note.success', 'You have successfuly add new product');

            return redirect('/products');
        }
    }

    /**
     * Display the specified product.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::where('id', '=', $id)->first();

        $images = Images::where('product_id', '=', $id)->get()->toArray();

        return view('products.edit', ['product' => $product, 'images' => $images]);
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\ProductRequest $request, $id)
    {


        $update = Products::where('id', $id)->update([

            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'count' => $request->input('count'),
            'discount' => $request->input('discount'),
        ]);

        if ($update) {
            $picture = '';
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $picture = md5(microtime()) . '.' . $extension;
                    $destinationPath = base_path() . '\public\img\products';
                    $file->move($destinationPath, $picture);

                    $images = Images::create(array(
                        'product_id' => $id,
                        'name' => $picture
                    ));
                }
            }

            return redirect('/products');
        }


    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        $product->delete();

        return response()->json(['status' => true, 'message' => 'Product deleted successfully!']);

    }

    /**
     * @return mixed
     */
    public function deleteImage(Request $request)
    {
        $id = $request->input('id');

        $image = Images::find($id);
        $image->delete();

        return response()->json(['status' => true, 'message' => 'Image deleted successfully!']);

    }

    /**
     * @return string
     */
    public function changeThumb(Request $request)
    {
        $image_id = $request->input('image_id');
        $product_id = $request->input('product_id');

        $updateOldImage = Images::where('product_id', $product_id)
            ->where('is_thumb', '=', 1)
            ->update([
                'is_thumb' => 0,
            ]);

        $updateNewImage = Images::where('product_id', $product_id)
            ->where('id', '=', $image_id)
            ->update([
                'is_thumb' => 1,
            ]);

        return response()->json(['status' => true, 'message' => 'Thumb changed successfully!']);
    }
}
