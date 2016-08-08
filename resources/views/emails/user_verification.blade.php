@extends('layouts.email_layout')

@section('title')


@stop

@section('content')

    <h3>Hi {{ $user->first_name }}</h3>

    <p>
        Thank you for registering in our site!
        <br/>
        Please verify your email address by clicking the following <a href='{{ url("auth/verify/{$user->email_token}") }}'>link</a> .
    </p>
@stop
