@extends('layouts.app')
@section('title', 'Edit Stockpile')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @include('layouts.flash_errors')
    @isset($stockpile)
    {!! Form::model($stockpile, ['route' => ['stockpile.update', $stockpile->stockpile_id], 'method' => 'patch','enctype'=> 'multipart/form-data']) !!}
    @else
    {!! Form::open(['route' => 'stockpile.store']) !!}
    @endif
    @csrf

    <div class="form-group row">
        <label for="name"
        class="col-md-4 col-form-label text-md-right">Name</label>
        <div class="col-md-6">
            <input id="name" type="text" class="form-control"value="{{  $stockpile->stockpile_name  }}" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label for="address"
        class="col-md-4 col-form-label text-md-right">Address</label>
        <div class="col-md-6">
            <input id="address" type="text" class="form-control"value="{{  $stockpile->stockpile_address  }}" disabled>
        </div>
    </div>

    <div class="form-group row">
        <label for="latitude"
        class="col-md-4 col-form-label text-md-right">Latitude</label>
        <div class="col-md-6">
            <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror"
            name="latitude" value="{{ isset($stockpile->latitude) ? $stockpile->latitude :  old('latitude') }}">
            @error('latitude')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="longitude"
        class="col-md-4 col-form-label text-md-right">Longitude</label>
        <div class="col-md-6">
            <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror"
            name="longitude" value="{{ isset($stockpile->longitude) ? $stockpile->longitude :  old('longitude') }}">
            @error('latitude')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="photo1" class="col-md-4 col-form-label text-md-right">Photo 1</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('photo1') is-invalid @enderror" name="photo1">
            @error('photo1')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="photo2" class="col-md-4 col-form-label text-md-right">Photo 2</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('photo2') is-invalid @enderror" name="photo2">
            @error('photo2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="photo3" class="col-md-4 col-form-label text-md-right">Photo 4</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('photo3') is-invalid @enderror" name="photo3">
            @error('photo3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="photo4" class="col-md-4 col-form-label text-md-right">Photo 4</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('photo4') is-invalid @enderror" name="photo4">
            @error('photo4')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <div class="offset-md-4">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
    {!! Form::close() !!}

</div>

@endsection
