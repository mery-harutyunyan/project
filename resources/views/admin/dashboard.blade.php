@extends('layouts.admin')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Products
        </h3>

        <a href="addProduct" class="btn btn-primary">Add Product</a>

        @if(!empty($products))
            <table class="table table-bordered table-striped">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Actions</th>
                </tr>


                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>
                            @if($product->photo)
                                <img height="30" src="/img/products/{{$product->photo}}" alt="">
                            @else
                                <img height="30" src="/img/products/product_default.png" alt="">
                            @endif
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->count}}</td>
                        <td>
                            <a href="editProduct/{{$product->id}}" class="btn btn-primary">Edit</a>
                            <a href="deleteProduct/{{$product->id}}" class="btn btn-danger">Delete</a>


                        </td>
                    </tr>
                @endforeach
            </table>

            {!! $products->render() !!}
        @else
            <p>
                No products found
            </p>
        @endif
    </div>
@stop