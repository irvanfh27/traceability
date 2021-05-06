@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            <tr>
{{--                <td>#</td>--}}
                <td scope="col">Name</td>
                <td scope="col">Address</td>
                <td scope="col">Province</td>
                <td scope="col">Districts</td>
                <td scope="col">Production Capacity</td>
                <td scope="col" width="120px">Action</td>
            </tr>
            </thead>
            <tbody>
{{--            @foreach($vendors as $row)--}}
{{--                <tr>--}}
{{--                    <th scope="row">{{$row->vendor_id}}</th>--}}
{{--                    <td>{{$row->vendor_name}}</td>--}}
{{--                    <td>{{$row->vendor_address}}</td>--}}
{{--                    <td>{{ $row->province_name}}</td>--}}
{{--                    <td>{{ $row->district_name}}</td>--}}
{{--                    <td>{{ $row->kapasitas_produksi }}</td>--}}
{{--                    --}}{{-- <td>{{isset($row->detail->latitude) ? $row->detail->latitude : ''}}</td> --}}
{{--                    --}}{{-- <td>{{isset($row->detail->longitude) ? $row->detail->longitude : ''}}</td> --}}
{{--                    <td width="120px">--}}
{{--                        <a class="btn btn-primary" href="{{ route('vendor.show',$row->vendor_id) }}">Detail</a>--}}
{{--                        <a class="btn btn-success" href="{{ route('vendor.edit',$row->vendor_id) }}">Edit</a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
            </tbody>
        </table>
    </div>
@stop
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table').DataTable({
                dom: 'lfrtirp',
                deferRender: true,
                "ajax": "{{ route('vendor.index') }}",
                "columns": [
                    {"data": "vendor_name"},
                    {"data": "vendor_address"},
                    {"data": "province_name"},
                    {"data": "district_name"},
                    {"data": "kapasitas_produksi"},
                    {"data": "action_button"},
                ],
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        });
    </script>
@endpush
