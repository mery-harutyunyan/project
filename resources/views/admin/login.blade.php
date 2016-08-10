@extends('layouts.start')

@section('title')

Login page
@stop

@section('content')

    <div class="panel panel-info ">
        <div class="panel-heading">
            <div class="panel-title">Sign In</div>

        </div>

        <div style="padding-top:30px" class="panel-body">

            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>



            {!! Form::open(
                   array(
                       'url' => 'admin/login',
                       'method' => 'post'
                   ),
                   array(
                       "id"=>"loginform",
                       "class"=>"form-horizontal"
                   )
               )
            !!}
            <div class="error">{{ $errors->first('user_error') }}</div>

            <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span>


                {!! Form::text('email', null,
                    array(
                       'class'=>'form-control',
                       'placeholder'=>'Your email'
                    ))
                !!}
                <div class="error">{{ $errors->first('email') }}</div>
            </div>

            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>


                {!! Form::password('password',
                    array(
                        'class'=>'form-control',
                        'placeholder'=>'password'
                    ))
                !!}
                <div class="error">{{ $errors->first('password') }}</div>
            </div>

            <div style="margin-top:10px" class="form-group">

                <div class="col-sm-12 controls">
                    {!! Form::submit('Login',
                         array(
                            'class'=>'btn btn-success'
                         ))
                     !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-12 control">
                    <div style="border-top: 1px solid #888; padding-top:15px; font-size:85%">
                        Don't have an account!
                        <a href="/auth/register">
                            Sign Up Here
                        </a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
