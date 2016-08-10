@extends('layouts.admin')

@section('title')
    Edit product
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Edit product
        </h3>


        {{ Form::model($product, ['method' => 'PATCH', 'route'=> ['products.update',$product->id ]]) }}

        <div class="form-group">
            {{Form::label('name', 'Name', array('class' => 'col-sm-2 control-label'))}}
            <div class="col-sm-10">
                {!! Form::text('name',$product->name,
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
                {!! Form::textarea('description', $product->description,
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
                {!! Form::text('price',$product->price,
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
                {!! Form::text('discount', $product->discount,
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
                {!! Form::text('count', $product->count,
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
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop