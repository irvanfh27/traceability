@extends('layouts.app')
@section('title', 'Stockpile Detail')

@section('content')
    <table class="table mt-3" style="width:90%">
        <tbody>
        <tr>
            <th scope="col">Nama Stockpile</th>
            <td>{{$stockpile->stockpile_name}}</td>
        </tr>
        <tr>
            <th scope="row">Alamat Stockpile</th>
            <td>{{$stockpile->stockpile_address}}</td>
        </tr>
        <tr>
            <th scope="row">Total Supplier</th>
            <td>{{ $stockpile->total_supplier }}</td>
        </tr>
        <tr>
            <th scope="row">Available Inventory</th>
            <td>0</td>
        </tr>
        <tr>
            <th scope="row">Documents</th>
            {{--            <td><a href="{{ route('stockpile.document.create') }}" class="btn btn-primary">Add Document</a></td>--}}
        </tr>
        </tbody>
    </table>

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
                $doc = \App\MasterDocument::where('category_id',$cat->id)->where('stockpile_id',$stockpile->stockpile_id)->first();
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
                    <td><a class="btn btn-success" href="{{ route('document.stockpile',['stockpileId' => $stockpile->stockpile_id,'categoryId' => $cat->id]) }}">Edit</a></td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
       {{-- <div id="example1" style="width: 90%;"></div> --}}
    <!-- Optional JavaScript; choose one of the two! -->
@endsection

@push('js')
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.4/pdfobject.min.js"></script>
    <script>
        PDFObject.embed("/doc/MasterProposal.pdf", "#example1");
    </script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table1').DataTable({
            dom: 'frtBp',
            buttons: []
        });
    });
</script>
@endpush
