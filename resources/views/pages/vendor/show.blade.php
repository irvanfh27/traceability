@extends('layouts.app')
@section('title', 'Vendor Detail')

@section('content')
<table class="table mt-3" style="width:90%">
    <tbody>
        <tr>
            <th scope="col">Vendor Name</th>
            <td>{{$vendor->vendor_name}}</td>
            <td> <a class="btn btn-success" href="{{ route('vendor.edit',$vendor->vendor_id) }}">Edit Supplier</a></td>
        </tr>
        <tr>
            <th scope="col">PIC</th>
            <td>{{ isset($vendor->detail->pic_name) ? $vendor->detail->pic_name : ''}}</td>
        </tr>
        <tr>
            <th scope="row"> Vendor Address</th>
            <td>{{$vendor->vendor_address}}</td>
        </tr>
        <tr>
            <th scope="row">Office Phone Number</th>
            <td>{{ isset($vendor->detail->no_telp_office) ? $vendor->detail->no_telp_office : '' }}</td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone</th>
            <td>{{ isset($vendor->detail->no_telp_hp ) ? $vendor->detail->no_telp_hp  : '' }}</td>
        </tr>

        <tr>
            <th scope="row">Email/surel</th>
            <td>{{ isset($vendor->detail->email) ? $vendor->detail->email : '' }}</td>

        </tr>
        <tr>
            <th scope="row">Website/situs web</th>
            <td>{{ isset($vendor->detail->link_website) ? $vendor->detail->link_website : '' }}</td>
        </tr>

        <tr>
            <th scope="row">Production Capacity</th>
            <td>{{ isset($vendor->detail->kapasitas_produksi) ? $vendor->detail->kapasitas_produksi : '' }}</td>
        </tr>
    </tbody>
</table>
<div class="col-md-6">
    @include('layouts.flash_errors')
</div>
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <div class="form-group row">
        <div class="ml-5">
            <b style="font-size: 30px">Documents</b>
        </div>
    </div>
    <table class="table" style="width:90%" id="table1">
        <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Catergory Document</b></td>
                <td><b>Document Status</b></td>
                <td><b>Document Name</b></td>
                <td><b>Document No</b></td>
                <td><b>Document Date</b></td>
                <td><b>Document Expired Date</b></td>
                <td><b>Department</b></td>
                <td><b>Document PIC</b></td>
                <td><b>File</b></td>
                <td><b>Notes</b></td>
                <td><b>Status</b></td>
                <td><b>Action</b></td>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($category as $cat)
            @php
            $doc = \App\MasterDocument::where('category_id',$cat->id)->where('vendor_id',request()->route()->vendor)->first();
            if(isset($doc->documentStatusName)){
                $documentStatusName = $doc->documentStatusName;
                $document_name = $doc->document_name;
                $document_no = $doc->document_no;
                $document_date = $doc->document_date;
                $expired_date = $doc->expired_date;
            $department = $doc->department;
                $document_pic = $doc->document_pic;
                $remarks = $doc->remarks;
                $statusName = $doc->statusName;
                $file = $doc->file;
                $fileUrl = \Illuminate\Support\Facades\Storage::url('document/'.$doc->file);
            }else{
                $documentStatusName = 'Tidak Ada';
                $document_name = '';
                $document_no = '';
                $document_date = '';
                $expired_date = '';
                $department = '';
                $document_pic = '';
                $remarks = '';
                $statusName  = 'Tidak Aktif';
                $file = '';
                $fileUrl = '';
            }

            @endphp

            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $documentStatusName }}</td>
                <td>{{ $document_name }}</td>
                <td>{{ $document_no }}</td>
                <td>{{ $document_date }}</td>
                <td>{{ $expired_date }}</td>
                <td>{{ $department }}</td>
                <td>{{ $document_pic }}</td>
                <td><a href="{{ $fileUrl }}">{{ $file }}</a></td>
                <td>{{ $remarks }}</td>
                <td>{{ $statusName }}</td>
                <td><a class="btn btn-success" href="{{ route('document.supplier',['vendorId' => request()->route()->vendor,'categoryId' => $cat->id]) }}">Edit</a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <div class="form-group row">
        <div class="ml-5">
            <b style="font-size: 30px">Follow UP</b>
        </div>
        <div class="col-md-6">
            <a href="{{ route('followUp.supplier',request()->route()->vendor) }}" class="btn btn-primary">Add Follow Up</a>
        </div>
    </div>

    <table class="table mt-3" style="width:90%" id="table2">
        <thead>
            <tr>
                <td><b>No</b></td>
                <td><b>Follow Up Date</b></td>
                <td><b>PIC</b></td>
                <td><b>Contact Person</b></td>
                <td><b>Notes</b></td>
                {{-- <td><b>Action</b></td> --}}
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($vendor->followUp as $f)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $f->date_follow_up }}</td>
                <td>{{ $f->yang_menghubungi }}</td>
                <td>{{ $f->yang_di_hubungi }}</td>
                <td>{{ $f->keterangan }}</td>
                {{-- <td><a class="btn btn-success" href="{{ route('followUp.edit', $f->id) }}">Edit</a></td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Optional JavaScript; choose one of the two! -->
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table1').DataTable({
            dom: 'frtBp',
            buttons: []
        });
    });
    $(document).ready(function () {
        var table = $('#table2').DataTable({
            dom: 'frtBp',
            buttons: []
        });
    });
</script>
@endpush
