@if (request()->route()->getName() == 'document.stockpile')
    <input type="hidden" name="stockpile_id" value="{{ request()->route()->stockpileId }}">
@else
    <input type="hidden" name="vendor_id" value="{{ request()->route()->vendorId }}">
@endisset

{{-- <div class="form-group row">
    {!! Form::label('name', 'Name:', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div> --}}

<div class="form-group row">
    <label for="documentFor" class="col-md-4 col-form-label text-md-right">Dokumen Ada/Tidak</label>

    <div class="col-md-6">
        <select class="form-control @error('document_status') is-invalid @enderror" name="document_status">
            <option value="">Pilih Opsi</option>
            <option value="0" @php
                if (isset($doc->document_status) && $doc->document_status == 0) {
                    echo 'selected';
                }
            @endphp>Tidak Ada</option>
            <option value="1" @php
                if (isset($doc->document_status) && $doc->document_status == 1) {
                    echo 'selected';
                }
            @endphp>Ada</option>
        </select>
        @error('document_status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="category_id" class="col-md-4 col-form-label text-md-right">Jenis Dokumen</label>

    <div class="col-md-6">
        <input type="hidden" name="category_id" value="{{ request()->route()->categoryId }}">
        <select class="form-control" name="category" disabled>
            @foreach (\App\CategoryDocument::all() as $cat)
                <option value="{{ $cat->id }}" @php
                    if ($cat->id == request()->route()->categoryId) {
                        echo 'selected';
                    }
                @endphp>{{ $cat->name }}</option>
            @endforeach
        </select>

        @error('category_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>



<div class="form-group row">
    <label for="document_name" class="col-md-4 col-form-label text-md-right">Nama Dokumen</label>

    <div class="col-md-6">
        <input id="document_name" type="text" class="form-control @error('document_name') is-invalid @enderror"
            name="document_name"
            value="{{ isset($doc->document_name) ? $doc->document_name : old('document_name') }}">

        @error('document_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="document_no" class="col-md-4 col-form-label text-md-right">Nomor Dokumen</label>

    <div class="col-md-6">
        <input id="document_no" type="text" class="form-control @error('document_no') is-invalid @enderror"
            name="document_no" value="{{ isset($doc->document_no) ? $doc->document_no : old('document_no') }}">

        @error('document_no')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="document_date" class="col-md-4 col-form-label text-md-right">Tanggal Dokumen</label>

    <div class="col-md-6">
        <input type="date" class="form-control @error('document_date') is-invalid @enderror" name="document_date"
            value="{{ isset($doc->document_date) ? $doc->document_date : old('document_date') }}">
        @error('document_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="expired_date" class="col-md-4 col-form-label text-md-right">Tanggal Kadaluarsa</label>

    <div class="col-md-6">
        <input type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date"
            value="{{ isset($doc->expired_date) ? $doc->expired_date : old('expired_date') }}">
        @error('expired_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="department" class="col-md-4 col-form-label text-md-right">Instansi Yang Menerbitkan</label>

    <div class="col-md-6">
        <input id="department" type="text" class="form-control @error('department') is-invalid @enderror"
            name="department" value="{{ isset($doc->department) ? $doc->department : old('department') }}">

        @error('department')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="document_pic" class="col-md-4 col-form-label text-md-right">Nama Pejabat Yang</label>

    <div class="col-md-6">
        <input id="document_pic" type="text" class="form-control @error('document_pic') is-invalid @enderror"
            name="document_pic"
            value="{{ isset($doc->document_pic) ? $doc->document_pic : old('document_pic') }}">

        @error('document_pic')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="remarks" class="col-md-4 col-form-label text-md-right">Keterangan</label>
    <div class="col-md-6">
        <textarea class="form-control @error('remarks') is-invalid @enderror"
            name="remarks">{{ isset($doc->remarks) ? $doc->remarks : old('remarks') }}</textarea>
        @error('remarks')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="file" class="col-md-4 col-form-label text-md-right">File</label>
    <div class="col-md-6">
        <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>

    <div class="col-md-6">
        <select class="form-control" name="status">
            <option value="">Pilih Status</option>
            <option value="0" @php
                if (isset($doc->status) && $doc->status == 0) {
                    echo 'selected';
                }
            @endphp>Tidak Aktif</option>
            <option value="1" @php
                if (isset($doc->status) && $doc->status == 1) {
                    echo 'selected';
                }
            @endphp>Aktif</option>
        </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
