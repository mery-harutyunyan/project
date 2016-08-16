@extends('layouts.default')

@section('title')
    Orders
@stop

@section('content')
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">


                <div class="profile-userpic">
                    <img src="{{ URL::asset('img/user.jpg') }}" class="img-responsive" alt="">
                </div>

                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{ Auth::user()->first_name }}    {{ Auth::user()->last_name }}
                    </div>
                </div>

                @include('elements/profile_menu')


            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <h3>Orders</h3>
                <div class="col-md-12">
                    @if(!empty((array)$orders))

                        <table>
                            <tr>
                                <th>Image</th>
                                <th>Order item</th>
                                <th>Transaction id</th>
                                <th>Status</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        @if($order->product_photo)
                                            <img style="height: 80px !important;"
                                                 src="/img/products/{{$order->product_photo}}">
                                        @else
                                            <img style="height: 80px !important;"
                                                 src="/img/products/product_default.png">
                                        @endif
                                    </td>
                                    <td><a href="viewProduct/{{$order->product_id}}">{{$order->product_name}}</a></td>
                                    <td>{{$order->transaction_id}}</td>
                                    <td>{{$order->state}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        You do not have any orders
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop