@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <table id="table" class="table">
            <thead>
            {{-- <tr>
                <th>#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Provinsi</th>
                <th scope="col">Kabupaten</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Action</th>
            </tr> --}}
            <tr>
                <td>#</td>
                <td scope="col">Name</td>
                <td scope="col">Address</td>
                <td scope="col">Province</td>
                <td scope="col">Districts</td>
                <td scope="col">Production Capacity</td>
                <td scope="col">Latitude</td>
                <td scope="col">Longitude</td>
                <td scope="col">Action</td>
            </tr>
            </thead>
            <tbody>
            @foreach($vendors as $row)
                <tr>
                    <th scope="row">{{$row->vendor_id}}</th>
                    <td>{{$row->vendor_name}}</td>
                    <td>{{$row->vendor_address}}</td>
                    <td>{{ $row->province_name}}</td>
                    <td>{{ $row->district_name}}</td>
                    <td>{{isset($row->detail->kapasitas_produksi) ? $row->detail->kapasitas_produksi : ''}}</td>
                    <td>{{isset($row->detail->latitude) ? $row->detail->latitude : ''}}</td>
                    <td>{{isset($row->detail->longitude) ? $row->detail->longitude : ''}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('vendor.show',$row->vendor_id) }}">Details</a>
                        <!-- Button trigger modal -->
                        <a class="btn btn-success" href="{{ route('vendor.edit',$row->vendor_id) }}">Edit</a>
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
            var table = $('#table').DataTable();
        });
    </script>
@endpush
