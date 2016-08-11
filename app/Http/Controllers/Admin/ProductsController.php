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
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
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
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = md5(microtime()) . $filename;
                    $destinationPath = base_path() . '\public\img\products';
                    $file->move($destinationPath, $picture);

                    $images = Images::create(array(
                        'product_id' => $product->id,
                        'name' => $picture
                    ));
                }
            }

            Session::flash('note.success', 'You have successfuly add new product');

            return redirect('/products');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Products::where('id', '=', $id)->first();
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
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
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $picture = md5(microtime()) . $filename;
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
     * Remove the specified resource from storage.
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
}
