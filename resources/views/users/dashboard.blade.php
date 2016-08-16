@extends('layouts.default')

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

                @include('elements/profile_menu')


            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                User profile data goes here
            </div>
        </div>
    </div>
@stop