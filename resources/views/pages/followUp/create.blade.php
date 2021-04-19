@extends('layouts.app')
@section('title', 'Add/Edit Follow UP')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @if(isset($followUp))
    {!! Form::model($followUp, ['route' => ['followUp.update', $followUp->id], 'method' => 'patch']) !!}
    @else
    {!! Form::open(['route' => 'followUp.store']) !!}
    @endif
    @csrf
    <input type="hidden" name="vendor_id" value="{{ isset($followUp->vendor_id ) ? $followUp->vendor_id :  request()->route()->vendorId }}">

    <div class="form-group row">
        <label for="date_follow_up"
        class="col-md-4 col-form-label text-md-right">Tanggal Follow Up</label>

        <div class="col-md-6">
            <input id="date_follow_up" type="date" class="form-control @error('date_follow_up') is-invalid @enderror"
            name="date_follow_up" value="{{ isset($followUp->date_follow_up ) ? $followUp->date_follow_up :  old('date_follow_up') }}">
            @error('date_follow_up')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="yang_menghubungi"
        class="col-md-4 col-form-label text-md-right">Yang Menghubungi</label>

        <div class="col-md-6">
            <input id="yang_menghubungi" type="text" class="form-control @error('yang_menghubungi') is-invalid @enderror"
            name="yang_menghubungi" value="{{ isset($followUp->yang_menghubungi ) ? $followUp->yang_menghubungi :  old('yang_menghubungi') }}">
            @error('yang_menghubungi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group row">
        <label for="yang_di_hubungi"
        class="col-md-4 col-form-label text-md-right">Yang Dihubungi</label>

        <div class="col-md-6">
            <input id="yang_di_hubungi" type="text" class="form-control @error('yang_di_hubungi') is-invalid @enderror"
            name="yang_di_hubungi" value="{{ isset($followUp->yang_di_hubungi ) ? $followUp->yang_di_hubungi :  old('yang_di_hubungi') }}">
            @error('yang_di_hubungi')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan"
        class="col-md-4 col-form-label text-md-right">Keterangan</label>
        <div class="col-md-6">
            <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan">{{ isset($followUp->keterangan) ? $followUp->keterangan :  old('keterangan') }}</textarea>
            @error('keterangan')
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
