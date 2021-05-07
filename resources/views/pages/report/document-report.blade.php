@extends('layouts.app')
@section('title', 'Report Progress Document')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            <tr>
                <th scope="col">Stockpile</th>
                <th scope="col">Jumlah PKS Yang Telah Menerima List Dokumen</th>
                <th scope="col">Jumlah Pks Yang Telah Menerima Kelengkapan Dokumen</th>
                <th scope="col">Jumlah Document terkumpul</th>
                <th scope="col">Jumlah PKS Menolak Mengumpulkan Document</th>
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
                "ajax": "{{ route('report.document') }}",
                "columns": [
                    {"data": "stockpile"},
                    {"data": "pks_get_list_doc"},
                    {"data": "pks_send_doc_total"},
                    {"data": "total_document"},
                    {"data": "total_reject"},

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
