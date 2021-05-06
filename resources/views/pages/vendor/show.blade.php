@extends('layouts.app')
@section('title', 'Supplier Detail')

@section('content')
    <div class="row mt-3">
        <div class="col-md-6 card">
            <table class="table mt-3">
                <tbody>
                <tr>
                    <th scope="col">Supplier Name</th>
                    <td>{{$vendor->vendor_name}}</td>
                    <td><a class="btn btn-success" href="{{ route('vendor.edit',$vendor->vendor_id) }}">Edit
                            Supplier</a></td>
                </tr>
                <tr>
                    <th scope="col">PIC</th>
                    <td>{{ isset($vendor->detail->pic_name) ? $vendor->detail->pic_name : ''}}</td>
                </tr>
                <tr>
                    <th scope="row">Supplier Address</th>
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
                <tr>
                    <th scope="row">Document Status</th>
                    <td><b>{{ $vendor->document_status_name }}</b></td>
                    @if ($vendor->document_status == 0)
                        <td>
                            <a class="btn btn-warning" href="{{ route('vendor.edit',$vendor->vendor_id) }}">
                               PKS Has Receive Document List
                            </a>
                        </td>
                    @elseif ($vendor->document_status == 1)
                        <td>
                            <a class="btn btn-warning" href="{{ route('vendor.edit',$vendor->vendor_id) }}">
                                PKS Has Sent The Document List
                            </a>
                        </td>
                    @endif
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6 card">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @isset($vendor->detail->photo_1)
                        <div class="carousel-item active" data-toggle="modal" data-target="#exampleModal">
                            <img class="d-block w-100" src="{{ $vendor->detail->photo_1 }}" height="350px"
                                 alt="First slide">
                        </div>
                    @endisset

                    @isset($vendor->detail->photo_2)
                        <div class="carousel-item" data-toggle="modal" data-target="#exampleModal">
                            <img class="d-block w-100" src="{{ $vendor->detail->photo_2 }}" height="100%" width="100%"
                                 alt="Second slide">
                        </div>
                    @endisset
                    @isset($vendor->detail->photo_3)
                        <div class="carousel-item" data-toggle="modal" data-target="#exampleModal">
                            <img class="d-block w-100" src="{{ $vendor->detail->photo_3 }}" height="100%" width="100%"
                                 alt="Third slide">
                        </div>
                    @endisset

                    @isset($vendor->detail->photo_4)
                        <div class="carousel-item" data-toggle="modal" data-target="#exampleModal">
                            <img class="d-block w-100" src="{{ $vendor->detail->photo_4 }}" height="100%" width="100%"
                                 alt="Fourth slide">
                        </div>
                    @endisset
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="modal fade bd-example-modal-lg custom" id="exampleModal" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="carouselExample" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @isset($vendor->detail->photo_1)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ $vendor->detail->photo_1 }}" height="100%"
                                             width="100%" alt="First slide">
                                    </div>
                                @endisset

                                @isset($vendor->detail->photo_2)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $vendor->detail->photo_2 }}" height="100%"
                                             width="100%" alt="Second slide">
                                    </div>
                                @endisset
                                @isset($vendor->detail->photo_3)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $vendor->detail->photo_3 }}" height="100%"
                                             width="100%" alt="Third slide">
                                    </div>
                                @endisset

                                @isset($vendor->detail->photo_4)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ $vendor->detail->photo_4 }}" height="100%"
                                             width="100%" alt="Fourth slide">
                                    </div>
                                @endisset
                            </div>
                            <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        @include('layouts.flash_errors')
    </div>
    <div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
        <div class="form-group row">
           <div class="col-md-8">
            <div class="ml-5">
                <b style="font-size: 30px">Documents</b>
            </div>
           </div>
            <div class="col-md-4 text-right">
                <form class="form-inline" method="POST" enctype="multipart/form-data" action="{{ route('document.import',request()->route()->vendor) }}">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <button class="btn btn-primary">Import Document</button>
                </form>
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
                    <td><a class="btn btn-success"
                           href="{{ route('document.supplier',['vendorId' => request()->route()->vendor,'categoryId' => $cat->id]) }}">Edit</a>
                    </td>

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
            {{-- <div class="col-md-6">
                <a href="{{ route('followUp.supplier',request()->route()->vendor) }}" class="btn btn-primary">Add Follow Up</a>
            </div> --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table1').DataTable({
                dom: 'lfrtip',
                buttons: []
            });

            var table2 = $('#table2').DataTable({
                dom: 'Bfrtlp',
                buttons: [{
                    text: 'Add Follow Up',
                    attr: {class: 'btn btn-primary'},
                    action: function (e, dt, node, config) {
                        window.location = '{{ route('followUp.supplier',request()->route()->vendor) }}';
                    }
                }]
            });

            $('#carouselExampleControls').carousel({
                interval: false
            })

            $('#carouselExample').carousel({
                interval: false
            })
        });

    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endpush
