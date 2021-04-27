@extends('layouts.app')
@section('title', 'Halo , '.Auth::user()->name)

@section('content')

<div class="row">
    <div class="card col-12 mt-1 mr-5" style="height:50%;width: 50%;border-radius:1.5rem;padding:10px;">
        <div id='map' style="width: 98%; height: 500px;border-radius:1.5rem"></div>
    </div>
</div>

<div class="row">
    <div class="card mt-1 ml-1" style="height:450px;width: 49%;border-radius:1.5rem;padding:10px;">

        <h1 style="margin-left:5%;margin-right:auto;font-weight:bolder">
            <img src="img/marker.png" style="width:10%;">
            Stockpile
        </h1>

        <div class="row" id="stockpileDetail">

            <table class="table table-sm mt-2 ml-2">
                <tbody>
                    <tr>
                        <td style="font-size:150%;font-weight:bold">Stockpile</td>
                        <td style="font-size:120%;" id="stockpileName"></td>
                    </tr>
                    <tr>
                        <td style="font-size:150%;font-weight:bold">Address</td>
                        <td style="font-size:120%;" id="stockpileAddress"></td>
                    </tr>
                    <tr>
                        <td style="font-size:150%;font-weight:bold">Total Supplier</td>
                        <td style="font-size:120%;" id="totalSupplier"></td>
                    </tr>
                    <tr>
                        <td style="font-size:150%;font-weight:bold">Inventory</td>
                        <td style="font-size:120%;" id="stockpileInventory"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center">
                            <a class="btn btn-primary" id="urlStockpile" href=""
                            style="width:50%;border-radius:1.5rem">Show More
                            &#x2192</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-1 ml-1" style="height:450px;width: 49%;border-radius:1.5rem;padding:10px;">

        <table id="tableSupplier" class="table table-sm mt-2 ml-2">
            <thead>
                <tr style="font-size:120%">
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Production Capacity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody style="font-size:100%">
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('css')
<style>
    td { font-size: 13px; }
    /* .markers {
        background-image: url("https://cdn1.iconfinder.com/data/icons/free-98-icons/32/map-marker-128.png");
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
    } */

    .markers {
        position: relative;
        cursor: pointer;
        text-align: center;
        /* background-size: cover; */
    }

    .mapboxgl-popup {
        max-width: 200px;
    }

    .mapboxgl-popup-content {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }
</style>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css' rel='stylesheet'/>
@endpush
@push('js')
{{-- <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script> --}}
{{--    <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>--}}
{{--    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>--}}
<script src='https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js'></script>
{{-- <script src="{{ asset('vendor') }}/popper/popper.min.js"></script>
<script src="{{ asset('vendor') }}/bootstrap/bootstrap.min.js"></script>
<script src="{{ asset('vendor') }}/headroom/headroom.min.js"></script>
<!-- Optional JS -->
<script src="{{ asset('vendor') }}/onscreen/onscreen.min.js"></script>
<script src="{{ asset('vendor') }}/nouislider/js/nouislider.min.js"></script> --}}
<script src="{{ asset('vendor') }}/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- Argon JS -->
{{--    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet'/>--}}
<script>
    var stockpileMaps = "{{ route('api.stockpileMaps') }}";
    var supplierMaps = "{{ url('api/supplierMaps') }}";

    var stockpileData = {!! $stockpileJson !!}
    console.log(stockpileData)
    // $.noConflict();
</script>
<script src="{{ asset('js') }}/maps.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> --}}
<script>
    // $.noConflict();
    var table = $('#tableSupplier').DataTable({
        scrollY:        280,
        deferRender:    true,
        scroller:       true,
        buttons: [],
        "ordering": false,
        "columns": [
        { "data": "vendor_name" },
        { "data": "vendor_address" },
        { "data": "kapasitas_produksi" },
        { "data": "button" }

        ]
    });
    const loadTableSupllier = (url) => {
        table.ajax.url(url).load()
    }
</script>
@endpush

</html>
