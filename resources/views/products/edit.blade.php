@extends('layouts.admin')

@section('title')
    Edit product
@stop

@section('content')
    <div class="row profile profile-content">


        <h3>
            Edit product
        </h3>


        {{ Form::model($product, ['method' => 'PATCH', 'route'=> ['products.update',$product->id ], 'id'=>'edit-product', 'files'=> true, 'class'=>'form-horizontal']) }}

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


                @if(!empty($images))
                    <div class="row">
                        @foreach($images as $image)

                            <div class="col-md-2 imageDiv" image-div="{{$image['id']}}">
                                <div class="thumbnail">
                                    <img height="100" src="/img/products/{{$image['name']}}"/>
                                    <div class="caption">
                                        <p>
                                            <button type="button" image-id="{{$image['id']}}"
                                                    class="delete-image btn btn-xs btn-danger" role="button">Delete
                                            </button>
                                        </p>
                                        @if($image['is_thumb'] == 0)
                                            <p>
                                                <button type="button" product-id="{{$product->id}}"
                                                        image-id="{{$image['id']}}"
                                                        class="make-thumb btn btn-xs btn-primary" role="button">
                                                    Make thumb
                                                </button>
                                            </p>
                                        @else
                                            <p class="thumb" thumb-id="{{$image['id']}}">
                                                This is thumb
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>


                @endif

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

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', 'button.delete-image', function (e) {
            var image_id = $(this).attr('image-id');

            $.ajax({
                url: '/products/deleteImage',
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": image_id,
                    "_token": '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.status) {
                        $('.imageDiv[image-div="' + image_id + '"]').remove();

                        $.notify({
                            message: data.message,
                        }, {
                            delay: 2000,
                            type: 'success',
                        });
                    }
                }
            })
        });

        $(document).on('click', 'button.make-thumb', function (e) {
            var image_id = $(this).attr('image-id');
            var product_id = $(this).attr('product-id');

            var $this = $(this);
            $.ajax({
                url: '/products/changeThumb',
                type: 'POST',
                dataType: "JSON",
                data: {
                    "image_id": image_id,
                    "product_id": product_id,
                    "_token": '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.status) {

                        //remove all thumb styles
                        var old_image_id = $('p.thumb').attr('thumb-id');
                        $('p.thumb').html(
                                '<button type="button" product-id="' + product_id + '"   image-id="' + old_image_id + '" class="make-thumb btn btn-xs btn-primary" role="button">Make thumb </button>'
                        );

                        $('p.thumb').removeAttr('thumb-id');
                        $('p.thumb').removeAttr('class')


                        // add styles for new thumb
                        $this.parent('p').attr({
                            'class': 'thumb',
                            'thumb-id': image_id
                        });
                        $this.parent('p').html('This is thumb');
                        $this.remove();


                        $.notify({
                            message: data.message,
                        }, {
                            delay: 2000,
                            type: 'success',
                        });
                    }
                }
            })
        });

        $('#edit-product').validate({
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
    });
</script>
@endpush

