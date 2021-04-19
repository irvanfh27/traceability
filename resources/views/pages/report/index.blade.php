@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<div class="card mt-3 mr-5" style="border-radius: 2rem;padding:15px 15px 15px 15px">
    <table id="table" class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Vendor</th>
                <th scope="col">Document</th>
                <th scope="col">Percentage Document</th>
                <th scope="col">Collection(TON)</th>
                <th scope="col">Total Production(TON)</th>
                <th scope="col">Colection Rate</th>
                <th scope="col">Follow Up Date</th>
                <th scope="col">Follow Up Status</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($vendors as $row)
            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{$row->vendor_name}}</td>
                <td>{{$row->total_document}}</td>
                <td>{{$row->percentage_document}}</td>
                <td>{{ $row->collection_ton}}</td>
                <td>{{ $row->kapasitas_produksi_ton }}</td>
                <td>{{$row->collection_rate}}</td>
                <td>{{ isset($row->latestFollowUp->date_follow_up) ? $row->latestFollowUp->date_follow_up : ""}}</td>
                <td>{{ isset($row->latestFollowUp->keterangan) ? $row->latestFollowUp->keterangan : ""}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('js')

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'excelHtml5',
            'pdfHtml5'
            ],
            "ordering": false,
        });

    });
</script>
@endpush
