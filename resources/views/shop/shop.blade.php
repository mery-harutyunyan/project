@extends('layouts.default')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="row profile">

        <div class="profile-content">
            <h3>
                Products
            </h3>
            <div class="row">
                @if(!empty($products))
                    @foreach( $products as $product)
                        <div class="col-md-12">
                            <div class="col-md-3">
                                @if($product->photo)
                                    <img height="150" src="/img/products/{{$product->photo}}" alt="">
                                @else
                                    <img height="150" src="/img/products/product_default.png" alt="">
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h3>{{$product->name}}</h3>
                                <p>
                                    @if(strlen($product->description) > 90)
                                        {{ substr($product->description,0, 87).'...' }}
                                    @else
                                        {{$product->description}}
                                    @endif
                                </p>
                                <p>Discount : {{$product->discount}}%</p>
                                <p>Price : ${{$product->price}}</p>
                                <p>
                                    <a href="viewProduct/{{$product->id}}" class="btn btn-primary pull-right"
                                       role="button">View</a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12 text-center">
                        {!! $products->render() !!}
                    </div>
                @else
                    <p> No products found </p>
                @endif
            </div>
        </div>

    </div>
@stop