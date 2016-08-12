@extends('layouts.start')

@section('title')

    Login page
@stop


<style>
    #login-form .form-group{
        padding-left: 15px;
        padding-right: 15px;
    }
</style>

@section('content')

    <div class="panel panel-info ">
        <div class="panel-heading">
            <div class="panel-title">Sign In</div>
            {{--<div style="float:right; font-size: 80%; position: relative; top:-10px">--}}
            {{--<a href="#">Forgot password?</a>--}}
            {{--</div>--}}
        </div>

        <div  class="panel-body">

            {!! Form::open(
                   array(
                       'url' => 'auth/login',
                       'method' => 'post',
                       "id"=>"login-form",
                       "class"=>"form-horizontal"
                   )
               )
            !!}

            <div class="form-group">
                <div class="input-group ">
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
                <span class="help-block">{{ $errors->first('email') }}</span>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    {!! Form::password('password',
                        array(
                            'class'=>'form-control',
                            'placeholder'=>'password'
                        ))
                    !!}
                </div>
                <div class="help-block">{{ $errors->first('password') }}</div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 controls">
                    {!! Form::submit('Login',
                         array(
                            'class'=>'btn btn-primary pull-right'
                         ))
                     !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-12 control">
                    <div style="border-top: 1px solid #888; padding-top:15px; margin-top:15px; font-size:85%">
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#login-form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please enter password",
                },

            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        })
    })
</script>
@endpush