@extends('layouts.app')
@section('title', 'Document')

@section('content')
<div class="row">
    <div class="card" style="margin-left: 20px">
        {{-- <a  href="{{ route('document.create') }}" class="btn btn-primary">Add Document</a> --}}
    </div>
</div>
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <table id="table" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <td><b>Catergory Document</b></td>
                <td><b>Department</b></td>
                <td><b>File</b></td>
                <td><b>Expired Date</b></td>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($documents as $doc)
            <tr>
                <th scope="row">{{$no++}}</th>
                <td>{{ $doc->categoryName }}</td>
                <td>{{ $doc->department }}</td>
                <td><a href="{{ \Illuminate\Support\Facades\Storage::url('document/'.$doc->file) }}">{{ $doc->file }}</a> </td>
                <td>{{ $doc->expired_date }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('document.show',$doc->id) }}">Detail</a>
                    {{-- <a class="btn btn-warn" href="{{ route('document.edit',$doc->id) }}">Edit</a> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
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
