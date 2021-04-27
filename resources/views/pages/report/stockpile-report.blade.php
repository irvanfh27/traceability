@extends('layouts.app')
@section('title', 'Reports Stockpile')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            <tr>
                <th scope="col">Stockpile</th>
                <th scope="col">Total PKS yang harus di follow up</th>
                <th scope="col">PKS Followed Up</th>
                <th scope="col">PKS Response</th>
                <th scope="col">Jumlah Doc terkumpul</th>
                <th scope="col">% Progress</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
@push('js')

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table').DataTable({
                dom: 'lfrtBp',
                deferRender: true,
                "ajax": "{{ route('api.report.stockpile') }}",
                "columns": [
                    {"data": "stockpile_name"},
                    {"data": "pks_not_followed_up"},
                    {"data": "pks_followed_up"},
                    {"data": "pks_response"},
                    {"data": "total_document"},
                    {"data": "progress"},
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
@endpush
