@extends('layouts.admin')

@section('title')
    Add product
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Add product
        </h3>


        {{ Form::open(array('url' => url('products'),'id'=>'add-product', 'class'=>'form-horizontal', 'files'=> true)) }}

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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#add-product').validate({
            rules: {
                name: {
                    required: true,
                },
                description: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true
                },
                discount: {
                    number: true,
                    range: [0, 100]
                },
                count: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                name: {
                    required: "Please enter product name",
                },
                description: {
                    required: "Please enter product description",
                },
                price: {
                    required: "Please enter product price",
                    number: "Product price must be number",
                },
                discount: {
                    number: "Product discount must be number",
                    range: "Discount must be in (0,100) range ",
                },
                count: {
                    required: "Please enter product count",
                    digits: "Product price must be number",
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