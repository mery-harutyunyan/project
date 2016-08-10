@extends('layouts.admin')

@section('title')
    Dashboard
@stop

@section('content')
    <div class="row profile profile-content">
        <h3>
            Products
            <a href="/products/create" class="btn btn-xs btn-primary pull-right">
                <i class="glyphicon glyphicon-plus"></i>Add Product
            </a>
        </h3>

        <table class="table table-bordered" id="products">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Count</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@stop

@push('scripts')
<script>
    $(document).ready(function () {
        var products_table = $('#products').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[2, 4, 8, -1], [2, 4, 8, "All"]],
            pageLength: 2,
            ajax: {
                url: '{!! route('products.data') !!}',
                type: 'GET'
            },
            columns: [
                {data: 0, name: 'id'},
                {data: 1, name: 'name'},
                {data: 2, name: 'count'},
                {data: 3, name: 'created_at', searchable: false},
                {data: 4, name: 'updated_at', searchable: false},
                {data: 5, name: 'action', orderable: false, searchable: false}
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': window.token
            }
        });
        $(document).on('click', 'button.delete-product', function (e) {
            var $this = $(this);
            $.ajax({
                type: $this.data('method'),
                url: $this.data('href'),
                success: function (data) {
                    if (data.status) {
                        products_table.ajax.reload();
                    }
                }
            })
        });
    });
</script>
@endpush