@extends('layouts.app')
@section('title', 'Category Document')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @include('layouts.flash_errors')
    <div class="col-md-5">
        <a href="{{ route('category.create') }}" class="btn btn-primary"> Add Category</a>
    </div>
    <table id="table" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th scope="col">Name</th>
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
            dom: 'frtBp',
            buttons: [
            'csv'
            ]
        });
    });
</script>
@endpush
