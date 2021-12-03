@extends('layouts.app')

@section('container')

<button id="logoutBtn">Logout</button>

<script>
    jQuery(document).ready(function () {
        jQuery('#logoutBtn').click(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/api/logout') }}",
                method: 'post',
                data: {
                },
                success: function (result) {
                    console.log(result);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    });
</script>
@endsection