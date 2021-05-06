@extends('layouts.app')
@section('title', 'Reports Supplier')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="tableSupplierReport" class="table">
            <thead>
            <tr>
                {{--                <th scope="col">#</th>--}}
                <th scope="col">Vendor</th>
                <th scope="col">Document</th>
                <th scope="col">Percentage Document</th>
                {{-- <th scope="col">Collection(TON)</th> --}}
                {{-- <th scope="col">Total Production(TON)</th> --}}
                {{-- <th scope="col">Colection Rate</th> --}}
                <th scope="col">Follow Up Date</th>
                <th scope="col">Follow Up Status</th>
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
            var table = $('#tableSupplierReport').DataTable({
                dom: 'lfrtBp',
                deferRender: true,
                "ajax": "{{ route('report.supplier') }}",
                "columns": [
                    {"data": "vendor"},
                    {"data": "total_document"},
                    {"data": "percentage_document"},
                    {"data": "date_follow_up"},
                    {"data": "keterangan"},
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
