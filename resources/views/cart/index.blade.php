@extends('layouts.default')

@section('title')
    Cart
@stop

@section('content')
    <div class="row profile">
        <div class="profile-content">
            <h3>
                Shopping cart
            </h3>
            <div class="col-md-12">
                @if(($cartData))
                    {!! Form::open(
                        array(
                            'url' => url('paypal'),
                            'id' =>'cart-form'
                            )
                        )
                    !!}
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Product title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total price</th>
                        </tr>

                        @foreach($cartData as $data)

                            <?php $price = round($data['price'] * (1 - ($data['discount'] / 100)), 1, PHP_ROUND_HALF_UP) ?>

                            <tr cart-id="{{$data['cart_id']}}">
                                <td>
                                    {{ Form::checkbox("data[".$data['id']."][agree]", 1, true, array(
                                            'class'=>'checkbox'
                                        ))
                                    }}
                                </td>
                                <td>
                                    @if($data['photo'])
                                        <img style="height: 80px !important;" src="/img/products/{{$data['photo']}}">
                                    @else
                                        <img style="height: 80px !important;" src="/img/products/product_default.png">
                                    @endif
                                </td>
                                <td>{{$data['name']}}</td>
                                <td>
                                    @if($data['discount'])
                                        <p class="text-muted">
                                            <del>${{$data['price']}}</del>
                                        </p>
                                        <p>${{$price}}</p>
                                    @else

                                        <p>${{$price}}</p>
                                    @endif

                                </td>
                                <td>
                                    {{
                                        Form::number("data[".$data['id']."][cart_count]", $data['cart_count'], array(
                                            'min' => 1,
                                            'max' => $data['count'],
                                            'step' => 1,
                                            'class' => 'cart-count'
                                        ))
                                    }}

                                    {{
                                        Form::hidden("data[".$data['id']."][price]", $price, array(
                                        'class' => 'price'
                                        ))
                                    }}

                                </td>
                                <td class="item-price">${{$price*$data['cart_count']}}</td>
                            </tr>
                        @endforeach
                    </table>


                    <div class="col-md-4 pull-right">
                        <h3>Summary</h3>

                        <table class="col-md-12" cellpadding="30">
                            <tr style="border-bottom: 1px dashed">
                                <td>
                                    Items count:
                                </td>
                                <td align="right" class="buy-all-count">
                                    {{$cartCount}}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Total:
                                </td>
                                <td align="right">
                                    $<span class="cart-all-price">
                                    {{$sum}}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <div class="pull-right">
                            {!! Form::submit('Buy now',
                                array(
                                   'class'=>'btn btn-primary'
                                ))
                            !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @else
                    <p>
                        Cart is empty
                    </p>
                @endif
            </div>

        </div>
    </div>
@stop

@push('scripts')
<script>
    $(document).ready(function () {
        $(".cart-count").bind('keyup mouseup', function () {
            updateItem($(this));

        });

        $(".checkbox").change(function () {
            calculateTotal();
        });


        function updateItem(item) {
            var count = item.val();
            var price = item.siblings('input.price').val();
            var cart_id = item.closest('tr').attr('cart-id');


            $.ajax({
                url: '/cart/updateCount',
                type: 'POST',
                dataType: "JSON",
                data: {
                    "cart_id": cart_id,
                    "count": count,
                    "_token": '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.status) {
                        item.closest('tr').children('.item-price').html('$' +Math.round(count * price * 100) / 100 );
                        calculateTotal(1);

                    }
                }
            })

        }

        function calculateTotal(updateTotalCount = null) {
            var data = $('form#cart-form').serializeForm();

            var sum = 0;
            var count = 0;
            $.each(data.data, function (index, value) {
                if (value.agree == 1) {
                    count += parseInt(value.cart_count);
                    sum +=Math.round(value.cart_count * value.price * 100) / 100 ;
                }
            });

            $('.buy-all-count').html(count);
            if (updateTotalCount == 1) {
                $('.cart-all-count').html(count);

            }
            $('.cart-all-price').html(sum);

        }
    });
</script>
@endpush