@extends('layouts.app')
@section('title', 'Stockpile')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <table id="table" class="table">
        <thead>
            {{-- <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Provinsi</th>
                <th scope="col">Kabupaten</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Action</th>
            </tr> --}}
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Provinsi</th>
                <th scope="col">Kabupaten</th>
                <th scope="col">Latitude</th>
                <th scope="col">Longitude</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stock as $row)
            <tr>
                <th scope="row">{{$row->stockpile_id}}</th>
                <td>{{$row->stockpile_name}}</td>
                <td>{{$row->stockpile_address}}</td>
                <td>{{$row->stockpile_provinsi}}</td>
                <td>{{$row->stockpile_kabupaten}}</td>
                <td>{{$row->latitude}}</td>
                <td>{{$row->longitude}}</td>
                <td><a class="btn btn-primary" href="{{ route('stockpile.show',$row->stockpile_id) }}">Details</a>
                    <!-- Button trigger modal -->
                    {{-- <button type="button" class="btn btn-success" data-toggle="modal"
                    data-target="#exampleModal">
                    Edit
                </button> --}}

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Stockpile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="stockpile_name">Nama Stockpile</label>
                                    <input type="text" class="form-control" id="stockpile_name"
                                    name="stockpile_name">
                                </div>
                                <div class="form-group">
                                    <label for="stockpile_address">Alamat Stockpile</label>
                                    <input type="text" class="form-control" id="stockpile_address"
                                    name="stockpile_address">
                                </div>
                                <div class="form-group">
                                    <label for="kabupaten">Kabupaten</label>
                                    <input type="text" class="form-control" id="kabupaten"
                                    name="kabupaten">
                                </div>
                                <div class="form-group">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi"
                                    name="provinsi">
                                </div>
                                <div class="form-group">
                                    <label for="link">Link GMaps</label>
                                    <input type="text" class="form-control" id="link" name="link">
                                </div>
                                <div class="form-group" style="margin-bottom:65%">
                                    <label for="link">Mapbox</label>
                                    <div id="map" style="width:auto;position:initial"></div>
                                    <pre id="coordinates" style="margin-bottom:65%" class="coordinates"
                                    hidden></pre>
                                </div>

                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude"
                                    name="latitude">
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude"
                                    name="longitude">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>

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
        var table = $('#table').DataTable();

    });
</script>
@endpush
