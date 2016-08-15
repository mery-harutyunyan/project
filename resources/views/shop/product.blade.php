@extends('layouts.default')

@section('title')
    Product
@stop

@section('content')

    <div class="col-md-12" style="background: white">

        <div class="col-md-6">
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
            <p> Price : ${{$product->price}}</p>
            <p> Discount : {{$product->discount}}%</p>
            <p> Availble : {{$product->count}}</p>

            <div>


                {!! Form::open(
                       array(
                           'url' => 'paypal',
                           'method' => 'post'
                       ),
                       array(
                           "id"=>"buyform",
                           "class"=>"form-horizontal"
                       )
                   )
                !!}


                <?php
                $counts = array();
                for ($i = 1; $i <= 10; $i++) {
                    $counts[$i] = $i;
                }

                ?>
                {!! Form::select('product_count',$counts, '1')  !!}

                <br/>
                {!! Form::hidden('discount_rate', $product->discount)  !!}
                {!! Form::hidden('product', $product->id)  !!}

                {!! Form::submit('Buy Now',
                     array(
                        'class'=>'btn btn-primary text-center'
                     ))
                 !!}

                {!! Form::close() !!}
            </div>
        </div>

    </div>

@stop

