@extends('layouts.start')

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
                        'method' => 'post',
                        "id"=>"signup-form",
                        "class"=>"form-horizontal"
                    )
                )
            !!}


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
                            'id' => 'password',
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
                           'class'=>'btn btn-primary pull-right'
                        ))
                    !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 control">
                    <div style="border-top: 1px solid #888; padding-top:15px; margin-top:15px; font-size:85%">
                        Have an account ?
                        <a href="/auth/login">
                            Sign In Here
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
        $('#signup-form').validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 8
                },
                password_confirmation: {
                    minlength: 3,
                    maxlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                },
                last_name: {
                    required: "Please enter your last name",
                },
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must have minimum 3 letters",
                    maxlength: "Password must have maximum 3 letters",
                },
                password_confirmation: {
                    minlength: "Password must have minimum 3 letters",
                    maxlength: "Password must have maximum 3 letters",
                    equalTo: "Passwords mismatch"
                }

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