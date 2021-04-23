@extends('layouts.app')
@section('title', 'Add/Edit Vendor')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">

    {!! Form::open(['route' => 'vendor.store', 'enctype' => 'multipart/form-data']) !!}
    @csrf
    <input type="hidden" name="vendor_id" value="{{ request()->route()->vendor }}">


    @isset($vendorHeader)
    <div class="form-group row">
        <label for="vendor_name" class="col-md-4 col-form-label text-md-right">Vendor Name</label>

        <div class="col-md-6">
            <input id="vendor_name" type="text" class="form-control " name="" value="{{ $vendorHeader->vendor_name }}"
            disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="vendor_address" class="col-md-4 col-form-label text-md-right">Vendor Address</label>

        <div class="col-md-6">
            <input id="vendor_address" type="text" class="form-control " name=""
            value="{{ $vendorHeader->vendor_address }}" disabled>
        </div>
    </div>
    @endisset


    <div class="form-group row">
        <label for="pic_name" class="col-md-4 col-form-label text-md-right">PIC Name</label>

        <div class="col-md-6">
            <input id="pic_name" type="text" class="form-control @error('pic_name') is-invalid @enderror"
            name="pic_name" value="{{ isset($vendor->pic_name) ? $vendor->pic_name : old('pic_name') }}">
            @error('pic_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="province" class="col-md-4 col-form-label text-md-right">Province(Propinsi)</label>

        <div class="col-md-6">
            <select id="province" class="form-control @error('province') is-invalid @enderror" name="province">
                <option>Select Province</option>
                @foreach ($province as $item)
                <option value="{{ $item->id }}" @php
                    if (isset($vendor->province) && $vendor->province == $item->id) {
                        echo 'selected';
                    }
                    @endphp>{{ $item->nama }}
                </option>
                @endforeach
            </select>
            @error('province')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="districts" class="col-md-4 col-form-label text-md-right">Districts(Kabupaten)</label>
        <div class="col-md-6">
            <select id="districts" class="form-control @error('districts') is-invalid @enderror" name="districts">
            </select>
            @error('districts')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="no_telp_office" class="col-md-4 col-form-label text-md-right">No Telp Office</label>

        <div class="col-md-6">
            <input id="no_telp_office" type="text" class="form-control @error('no_telp_office') is-invalid @enderror"
            name="no_telp_office"
            value="{{ isset($vendor->no_telp_office) ? $vendor->no_telp_office : old('no_telp_office') }}">
            @error('no_telp_office')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="no_telp_hp" class="col-md-4 col-form-label text-md-right">No Telp HP</label>

        <div class="col-md-6">
            <input id="no_telp_hp" type="text" class="form-control @error('no_telp_hp') is-invalid @enderror"
            name="no_telp_hp" value="{{ isset($vendor->no_telp_hp) ? $vendor->no_telp_hp : old('no_telp_hp') }}">
            @error('no_telp_hp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ isset($vendor->email) ? $vendor->email : old('email') }}">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="link_maps" class="col-md-4 col-form-label text-md-right">Link GMaps</label>
        <div class="col-md-6">
            <input id="link_maps" type="text" class="form-control @error('link_maps') is-invalid @enderror"
            name="link_maps" value="{{ isset($vendor->link_maps) ? $vendor->link_maps : old('link_maps') }}">
            @error('link_maps')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="link_website" class="col-md-4 col-form-label text-md-right">Link Website</label>
        <div class="col-md-6">
            <input id="link_website" type="text" class="form-control @error('link_website') is-invalid @enderror"
            name="link_website"
            value="{{ isset($vendor->link_website) ? $vendor->link_website : old('link_website') }}">
            @error('link_website')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="kapasitas_produksi" class="col-md-4 col-form-label text-md-right">Kapasitas Produksi(TON)</label>
        <div class="col-md-6">
            <input id="kapasitas_produksi" type="text"
            class="form-control @error('kapasitas_produksi') is-invalid @enderror" name="kapasitas_produksi"
            value="{{ isset($vendor->kapasitas_produksi) ? $vendor->kapasitas_produksi : old('kapasitas_produksi') }}">
            @error('kapasitas_produksi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="latitude" class="col-md-4 col-form-label text-md-right">Latitude</label>
        <div class="col-md-6">
            <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror"
            name="latitude" value="{{ isset($vendor->latitude) ? $vendor->latitude : old('latitude') }}">
            @error('latitude')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="longitude" class="col-md-4 col-form-label text-md-right">Longitude</label>
        <div class="col-md-6">
            <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror"
            name="longitude" value="{{ isset($vendor->longitude) ? $vendor->longitude : old('longitude') }}">
            @error('longitude')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>



    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#province').select2({
        placeholder: 'Select Province',
        allowClear: true
    });

    @isset($vendor->province)
    $('#districts').select2({
        placeholder: 'Select Districts',
        allowClear: true,
        ajax: {
            url: '{{ route('api.districts') }}',
            method: 'POST',
            data: {
                provinceId: '{{ $vendor->province }}'
            },
            dataType: 'json',
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
    @else
    $('#districts').select2({
        placeholder: 'Select Districts',
        allowClear: true
    });
    @endisset


    $('#province').on('change', function() {

        $('#districts').select2({
            placeholder: 'Select Districts',
            allowClear: true,
            ajax: {
                url: '{{ route('api.districts') }}',
                method: 'POST',
                data: {
                    provinceId: $(this).val()
                },
                dataType: 'json',
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

    });

</script>
@endpush

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
