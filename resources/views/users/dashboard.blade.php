@extends('layouts.default_layout')

@section('title')
    Dashboard
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



                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="#">
                                <i class="glyphicon glyphicon-user"></i>
                                Overview </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="glyphicon glyphicon-bookmark"></i>
                                My basket</a>
                        </li>

                    </ul>
                </div>


            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                Products
            </div>
        </div>
    </div>
@stop