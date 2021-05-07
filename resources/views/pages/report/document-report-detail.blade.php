@extends('layouts.app')
@section('title', $title)
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <table id="table" class="table">
        <thead>
            <tr>
                @if (request()->q == 'receiveListDocument')
                <th scope="col">Stockpile</th>
                <th scope="col">Nama PKS</th>
                {{-- <th scope="col">Jumlah Document terkumpul</th> --}}
                @elseif (request()->q == 'hasSentDocument')
                <th scope="col">Stockpile</th>
                <th scope="col">Nama PKS</th>
                <th scope="col">Jumlah Document terkumpul</th>
                @elseif (request()->q == 'hasAnyDocument')
                <th scope="col">Stockpile</th>
                <th scope="col">Nama PKS</th>
                <th scope="col">Jumlah Document terkumpul</th>
                <th scope="col">Percentage %</th>
                @elseif (request()->q == 'hasRejectDocument')
                <th scope="col">Stockpile</th>
                <th scope="col">Nama PKS</th>
                <th scope="col">Komentar</th>
                @endif
                {{-- <th scope="col">Komentar</th> --}}
                {{-- <th scope="col">Persentase %</th> --}}
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="col-md-5 mt-3">
    <a href="{{ route('report.document') }}" class="btn btn-primary">Back</a>
</div>
@endsection
@push('js')
@if (request()->q == 'receiveListDocument')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'lfrtBp',
            deferRender: true,
            "ajax":{
                "url": "{{ route('report.document.detail') }}",
                "data": {
                    "stockpileId": "{{ request()->stockpileId }}",
                    "q": "{{ request()->q }}"
                },
            },
            "columns": [
            {"data": "stockpile"},
            {"data": "vendor_name"},
            ],
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@elseif (request()->q == 'hasSentDocument')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'lfrtBp',
            deferRender: true,
            "ajax":{
                "url": "{{ route('report.document.detail') }}",
                "data": {
                    "stockpileId": "{{ request()->stockpileId }}",
                    "q": "{{ request()->q }}"
                },
            },
            "columns": [
            {"data": "stockpile"},
            {"data": "vendor_name"},
            {"data": "total_document"},

            ],
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@elseif (request()->q == 'hasAnyDocument')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'lfrtBp',
            deferRender: true,
            "ajax":{
                "url": "{{ route('report.document.detail') }}",
                "data": {
                    "stockpileId": "{{ request()->stockpileId }}",
                    "q": "{{ request()->q }}"
                },
            },
            "columns": [
            {"data": "stockpile"},
            {"data": "vendor_name"},
            {"data": "total_document"},
            {"data": "percentage_document"},

            ],
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@elseif (request()->q == 'hasRejectDocument')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'lfrtBp',
            deferRender: true,
            "ajax":{
                "url": "{{ route('report.document.detail') }}",
                "data": {
                    "stockpileId": "{{ request()->stockpileId }}",
                    "q": "{{ request()->q }}"
                },
            },
            "columns": [
            {"data": "stockpile"},
            {"data": "vendor_name"},
            {"data": "comment"},
            ],
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@endif

@endpush
