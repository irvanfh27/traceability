@extends('layouts.app')
@section('title', 'Reports Supplier Group')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            <tr>
                <th scope="col">Stockpile</th>
                @foreach($vendorGroups as $group)
                    <th scope="col">{{ $group->group_name }}</th>
                @endforeach
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
                {{--"ajax": "{{ route('report.stockpile') }}",--}}
                    {{--"columns": [--}}
                    {{--    {"data": "stockpile_name"},--}}
                    {{--    {"data": "pks_not_followed_up"},--}}
                    {{--    {"data": "pks_followed_up"},--}}
                    {{--    {"data": "pks_response"},--}}
                    {{--    {"data": "total_document"},--}}
                    {{--    {"data": "progress"},--}}
                    {{--],--}}
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
