@extends('layouts.default')

@section('title')
    Product
@stop

@section('content')

    <div class="col-md-12" style="background: white">

        <div class="col-md-6">
            @if($product->discount)
                <span class="label label-danger">- {{$product->discount}}%</span>
            @endif
            @if(count($images)>=2)
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">


                    <!-- Wrapper for slides -->
                    <div class="carousel-inner " role="listbox">

                        <?php $first = true ?>
                        @foreach($images as $image)

                            @if($first)
                                <div class="item active">
                                    <img height="250" src="/img/products/{{$image['name']}}" alt="{{$image['name']}}">
                                </div>
                                <?php $first = false ?>
                            @else
                                <div class="item">
                                    <img height="250" src="/img/products/{{$image['name']}}" alt="{{$image['name']}}">
                                </div>
                            @endif

                        @endforeach


                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            @elseif(count($images) == 1)
                <div class="col-md-12">
                    <img height="200" src="/img/products/{{$images[0]['name']}}"/>
                </div>
            @else
                <div class="col-md-12">
                    <img height="200" src="/img/products/product_default.png"/>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h2>
                {{$product->name}}
            </h2>
            <p> {{$product->description}}</p>


            <?php $price = round($product->price * (1 - ($product->discount / 100)), 1, PHP_ROUND_HALF_UP) ?>

            <p>
                @if($product->discount)
                    Price :
                    <del class="text-muted">${{$product->price}}</del>
                    <br/>
                    Discount price: ${{$price}}
                @else
                    Price : ${{$price}}
                @endif
            </p>

            <p> Availble : {{$product->count}}</p>

            @if($product->cart_id)
                <p class="text-danger">This product is in your cart</p>
            @else


                <div>
                    {!! Form::open(
                           array(
                                'url' => url('cart'),
                           )
                       )
                    !!}


                    <?php
                    $counts = array();
                    $limit = min(10, $product->count);
                    for ($i = 1; $i <= $limit; $i++) {
                        $counts[$i] = $i;
                    }
                    ?>

                    <div class="form-group">
                        {!! Form::select('product_count',$counts, '1')  !!}
                    </div>
                    {!! Form::hidden('product_id', $product->id)  !!}

                    <div class="form-group">
                        {!! Form::submit('Add to card',
                         array(
                            'class'=>'btn btn-primary text-center'
                         ))
                     !!}
                    </div>

                    {!! Form::close() !!}
                </div>

            @endif
        </div>

    </div>

@stop

