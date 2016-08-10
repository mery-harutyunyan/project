<?php
if (Session::has('note.error')) {
    $message = Session::get('note.error');
    $type = 'danger';
} elseif (Session::has('note.success')) {
    $message = Session::get('note.success');
    $type = 'success';
}

?>

@if(Session::has('note.error') || Session::has('note.success'))
    <script>
        $(document).ready(function () {
            $.notify({
                message: '{{$message}}',
            }, {
                delay: 2000,
                type: '{{$type}}',
            });
        })
    </script>
@endif