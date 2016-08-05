@extends('layouts.start_layout')



@section('content')

    <div class="panel panel-info ">
        <div class="panel-heading">
            <div class="panel-title">Sign In</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a>
            </div>
        </div>

        <div style="padding-top:30px" class="panel-body">

            <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>


            {!! Form::open(array('url' => 'foo/bar'),
               array(
               "id"=>"loginform",
                "class"=>"form-horizontal"
               )) !!}


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
            </div>

            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>


                {!! Form::password('password',
                    array(
                        'class'=>'form-control',
                        'placeholder'=>'password'
                    ))
                !!}
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
