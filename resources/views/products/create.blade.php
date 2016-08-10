@extends('layouts.admin')

@section('title')
    Add product
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Add product
        </h3>


        {{ Form::open(array('url' => url('products'), 'class'=>'form-horizontal', 'files'=> true)) }}

        <div class="form-group">
            {{Form::label('name', 'Name', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('name', null,
                   array(
                      'class'=>'form-control',
                      'placeholder'=>'Name'
                   ))
               !!}
                <div class="error">{{ $errors->first('name') }}</div>

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
                <div class="error">{{ $errors->first('description') }}</div>

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
                <div class="error">{{ $errors->first('price') }}</div>

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
                <div class="error">{{ $errors->first('discount') }}</div>

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
                <div class="error">{{ $errors->first('count') }}</div>

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
                <div class="error">{{ $errors->first('images') }}</div>

            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop