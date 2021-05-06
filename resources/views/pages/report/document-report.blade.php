@extends('layouts.app')
@section('title', 'Report Progress Document')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            <tr>
                <th scope="col">Stockpile</th>
                <th scope="col">JUMLAH PKS YANG TELAH MENERIMA LIST DOKUMEN</th>
                {{-- <th scope="col">NAMA PKS</th> --}}
                <th scope="col">JUMLAH PKS YANG TELAH MENGIRIMKAN KELENGKAPAN DOKUMEN</th>
                <th scope="col">Jumlah Document terkumpul</th>
                {{-- <th scope="col">Komentar</th> --}}
                {{-- <th scope="col">Persentase %</th> --}}
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
