@extends('layouts.admin')

@section('title')
    Add product
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Add product
        </h3>


        {{ Form::open(array('url' => url('foo/bar'), 'class'=>'form-horizontal', 'files'=> true)) }}

        <div class="form-group">
            {{Form::label('name', 'Name', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('name', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'Name'
                   ))
               !!}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('description', 'Description', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::textarea('description', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'Description'
                   ))
               !!}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('price', 'Price', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('price', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'price'
                   ))
               !!}
            </div>
        </div>

        <div class="form-group">
            {{Form::label('discount', 'Discount', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('discount', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'Discount'
                   ))
               !!}
            </div>
        </div>

        <div class="form-group">
            {{Form::label('count', 'Count', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('count', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'Count'
                   ))
               !!}
            </div>
        </div>

        <div class="form-group">
            {{Form::label('images', 'Images', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::file('images[]',
                   array(
                   'multiple'=>true,
                   ))
               !!}
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Sign in</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop