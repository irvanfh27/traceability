@extends('layouts.app')
@section('title', 'Add Document')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @if(isset($doc))
    {!! Form::model($doc, ['route' => ['document.update', $doc->id], 'method' => 'patch','enctype'=> 'multipart/form-data']) !!}
    {{-- <form method="PATCH" action="{{ route('document.update',[$doc->id]) }}" enctype="multipart/form-data"> --}}
    @else
    {!! Form::open(['route' => 'document.store','enctype'=> 'multipart/form-data']) !!}
    {{-- <form method="POST" action="{{ route('document.store') }}" enctype="multipart/form-data"> --}}
    @endif
        @csrf
        @include('pages.document.fields')
        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    {{-- </form> --}}
    {!! Form::close() !!}
</div>

@endsection
