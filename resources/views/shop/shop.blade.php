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

                        <?php $price = round($product->price * (1 - ($product->discount / 100)), 1, PHP_ROUND_HALF_UP) ?>

                        <div class="col-md-3">
                            <div class="thumbnail">
                                @if($product->discount)
                                    <span class="label label-danger">- {{$product->discount}}%</span>
                                @endif
                                @if($product->photo)
                                    <img style="height: 150px !important;" src="/img/products/{{$product->photo}}"
                                         alt="">
                                @else
                                    <img style="height: 150px !important;" src="/img/products/product_default.png"
                                         alt="">
                                @endif
                                <div class="caption">
                                    <h3>{{$product->name}}</h3>
                                    <p>
                                        @if(strlen($product->description) > 90)
                                            {{ substr($product->description,0, 87).'...' }}
                                        @else
                                            {{$product->description}}

                                        @endif

                                    </p>

                                    <p>
                                        @if($product->discount)
                                            <span class="text-muted">
                                                <del>${{$product->price}}</del>
                                            </span>
                                            <span>${{$price}}</span>
                                        @else
                                            <span>${{$price}}</span>
                                        @endif
                                    </p>

                                    <p>
                                        <a href="viewProduct/{{$product->id}}" class="btn btn-primary" role="button">View</a>
                                    </p>
                                </div>
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