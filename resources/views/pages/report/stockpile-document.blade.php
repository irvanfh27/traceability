@extends('layouts.app')
@section('title', 'Reports Stockpile')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <table id="table" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Stockpile</th>
                <th scope="col">Total PKS yang harus di follow up</th>
                <th scope="col">PKS Followed Up</th>
                <th scope="col">PKS Response</th>
                <th scope="col">Jumlah Doc terkumpul</th>
                <th scope="col">% Progress</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($stockpiles as $row)
            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{$row->stockpile_name}}</td>
                <td>{{$row->pks_not_followed_up}}</td>
                <td>{{$row->pks_followed_up}}</td>
                <td>{{$row->pks_response}}</td>
                <td>{{$row->total_document}}</td>
                <td>{{$row->progress}}</td>
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
            dom: 'lfrtBp',
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@endpush
