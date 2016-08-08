@extends('layouts.start_layout')

@section('title')

    Registration page
@stop

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Sign Up</div>
            <div style="float:right; font-size: 85%; position: relative; top:-10px">
                <a id="signinlink" href="/auth/login">Sign In</a>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(
                    array(
                        'url' => 'auth/register',
                        'method' => 'post'
                    ),
                    array(
                        "id"=>"signupform",
                        "class"=>"form-horizontal"
                    )
                )
            !!}

            <div id="signupalert" style="display:none" class="alert alert-danger">
                <p>Error:</p>
                <span></span>
            </div>

            <div class="form-group">
                <label for="firstname" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    {!! Form::text('first_name', null,
                        array(
                           'class'=>'form-control',
                           'placeholder'=>'First Name'
                        ))
                    !!}
                    <div class="error">{{ $errors->first('first_name') }}</div>

                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    {!! Form::text('last_name', null,
                        array(
                           'class'=>'form-control',
                           'placeholder'=>'Last Name'
                        ))
                    !!}
                    <div class="error">{{ $errors->first('last_name') }}</div>
                </div>

            </div>

            <div class="form-group">
                <label for="email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">

                    {!! Form::text('email', null,
                        array(
                           'class'=>'form-control',
                           'placeholder'=>'Email Address'
                        ))
                    !!}
                    <div class="error">{{ $errors->first('email') }}</div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-3 control-label">Password</label>
                <div class="col-md-9">
                    {!! Form::password('password',
                        array(
                            'class'=>'form-control',
                            'placeholder'=>'password'
                        ))
                    !!}

                    <div class="error">{{ $errors->first('password') }}</div>

                </div>


            </div>

            <div class="form-group">
                <label for="icode" class="col-md-3 control-label">Confirm Password</label>
                <div class="col-md-9">
                    {!! Form::password('password_confirmation',
                        array(
                            'class'=>'form-control',
                            'placeholder'=>'password'
                        ))
                    !!}
                    <div class="error">{{ $errors->first('password_confirmation') }}</div>

                </div>
            </div>

            <div class="form-group">
                <!-- Button -->
                <div class="col-md-offset-3 col-md-9">

                    {!! Form::submit('Sign Up',
                        array(
                           'class'=>'btn btn-info'
                        ))
                    !!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@stop