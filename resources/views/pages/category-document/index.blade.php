@extends('layouts.app')
@section('title', 'Category Document')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @include('layouts.flash_errors')
    <table id="table" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th scope="col">Name</th>
                <th scope="col">For</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($categories as $row)
            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{$row->name}}</td>
                <td>{{ $row->category_for_name }}</td>
                <td>
                    <a class="btn btn-success" href="{{ route('category.edit',$row->id) }}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'Bfrtlp',
            buttons: [
            {
                text: 'Add Category',
                attr: {class: 'btn btn-primary'},
                action: function ( e, dt, node, config ) {
                    window.location = '{{ route('category.create') }}';
                }
            }
        ]
        });
    });
</script>
@endpush
