@extends('layouts.app')
@section('title', 'Add/Edit Category')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    @include('layouts.flash_errors')
    @isset($category))
    {!! Form::model($category, ['route' => ['category.update', $category->id], 'method' => 'patch']) !!}
    @else
    {!! Form::open(['route' => 'category.store']) !!}
    @endif
    @csrf

    <div class="form-group row">
        <label for="name"
        class="col-md-4 col-form-label text-md-right">Category Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ isset($category->name ) ? $category->name :  old('name') }}">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="category_for" class="col-md-4 col-form-label text-md-right">Category For</label>

        <div class="col-md-6">
            <select class="form-control @error('category_for') is-invalid @enderror" name="category_for">
                <option value="">Please Select</option>
                <option value="1" @php
                    if (isset($doc->category_for) && $doc->category_for == 1) {
                        echo 'selected';
                    }
                @endphp>Supplier</option>
                <option value="2" @php
                    if (isset($doc->category_for) && $doc->category_for == 2) {
                        echo 'selected';
                    }
                @endphp>Stockpile</option>
            </select>
            @error('category_for')
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
        @if (!isset($category))
        <div class="col-md-6">
            <button type="submit" name="next" value="true" class="btn btn-primary">
                Submit and insert next
            </button>
        </div>
        @endif
    </div>
    {!! Form::close() !!}

</div>

@endsection
