@extends('layouts.app')
@section('title', 'PKS Traceability With Code')

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row" style="background-color: #f5f5f5;
            margin-bottom: 5px; padding-top: 15px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;">
    <div class="offset3 span3">
        <form class="form-horizontal"  action="{{ route('report.pks.traceability') }}" method="get">
            @csrf
            <div class="control-group">
                <label class="control-label" for="searchShipmentId">Shipment Code</label>
                <div class="controls">
                <select class="livesearch form-control p-3" name="salesId"></select>
                </div>
            </div>
            <div class="control-group">
                <div class="controls mt-3">
                    <button type="submit" class="btn btn-primary" id="preview">Preview</button>
                </div>
            </div>
        </form>
    </div>
</div>
    {{-- <table class="table table-bordered table-striped">
    <thead>
    <tr>
    <th>Certification</th>
    <th>Vessel Name</th>
    <th>Begining Balance</th>
    <th>Total Quantity</th>
    <th>Ending Balance</th>
    </tr>
    </thead>
    <tbody>
        @foreach($pks1 as $row2)
        @php
            $value='';
			$no1=1;

			$slipOut = $row2->slipOut;
			$slipOutCode = $row2->slipOutCode;
			$shipmentNo = $row2->shipment_no;
			$transactionDate = $row2->transactionDate;
            $vessel_name = $row2->vessel_name;

                if($row2->slip_no >= 'SAM-0000000001' && $row2->slip_no <= 'SAM-0000001925'){
                    $fc_pph2 = 4 ;
                }else{
                    $fc_pph2	 = $row2->fc_pph;
                }

                if($row2->slip_no >= 'MAR-0000000001' && $row2->slip_no <= 'MAR-0000007138'){
                    $fc_pph2 = 4 ;
                }else{
                    $fc_pph2	 = $row2->fc_pph;
                }

                if($row2->vh_pph_tax_category == 1 && $row2->vh_pph_tax_id != ''){
			         $pphvh2 = ($row2->handling_total / ((100 - $row2->vh_pph) / 100)) - $row2->handling_total;

				 }elseif($row2->vh_pph_tax_category == 0 && $row2->vh_pph_tax_id != ''){
					  $pphvh2 =  0;
					 //$pphfc =  $row->freight_total - ($row->freight_total * ((100 - $fc_pph) / 100));
				 }else{
				 	$pphvh2 = 0;
				 }

				 $handlingTotal2 = $row2->handling_total - $pphvh2;


		         if($row2->fc_pph_tax_category == 1 && $row2->fc_pph_tax_id != ''){
			         $pphfc2 = ($row2->freight_total / ((100 - $fc_pph2) / 100)) - $row2->freight_total;
					 $pphfcShrink2 = ($row2->freight_shrink / ((100 - $fc_pph2) / 100)) - $row2->freight_shrink;

				 }elseif($row2->fc_pph_tax_category == 0 && $row2->fc_pph_tax_id != ''){
					  $pphfc2 =  0;
						$pphfcShrink2 = 0;
					 //$pphfc =  $row->freight_total - ($row->freight_total * ((100 - $fc_pph) / 100));
				 }else{
				 	$pphfc2 = 0;
					$pphfcShrink2 = 0;
				 }

				 $freightTotal2 = ($row2->freight_total + $pphfc2) - ($row2->freight_shrink + $pphfcShrink2);


				 if($row2->uc_pph_tax_category == 1 &&$row2->uc_pph_tax_id != ''){
			         $pphuc2 = ($row2->unloading_total / ((100 - $row2->uc_pph) / 100)) - $row2->unloading_total;

				 }elseif($row2->uc_pph_tax_category == 0 && $row2->uc_pph_tax_id != ''){
					 $pphuc2 =  0;
					 //$pphuc =  $row->unloading_total - ($row->unloading_total * ((100 - $row->uc_pph) / 100));
				 }else{
				 	$pphuc2 = 0;
				 }


                 $unloadingTotal2 = $row2->unloading_total + $pphuc2;

                $totalCogs2 = $row2->cogs_amount + $freightTotal2 + $unloadingTotal2 + $handlingTotal2;

                $quantity_total= $row2->quantity;
                $total_quantity = 0;
                $total_quantity = $quantity_total + $total_quantity;

                $pks_total = $row2->cogs_amount;
                $total_pks = 0;
                $total_pks += $pks_total;

                $fc_total = $freightTotal2;
                $total_fc = 0;
                $total_fc += $fc_total;

                $vh_total = $handlingTotal2;
                $total_vh = 0;
                $total_vh += $vh_total;

                $uc_total = $unloadingTotal2;
                $total_uc = 0;
                $total_uc += $uc_total;

                $cogs_total = $totalCogs2;
                $total_cogs = 0;
                $total_cogs += $cogs_total;
                
                $no1++;

            $test = DB::table('transaction as t')->select(DB::raw("ROUND(SUM(CASE WHEN t.transaction_type = 1 THEN t.quantity ELSE 0 END) -
	        SUM(CASE WHEN t.transaction_type = 2 THEN t.shrink ELSE 0 END),2) AS qty_available"))->where('t.slip_no','<',$slipOut)
            ->where('t.transaction_date','<=',$transactionDate)->where(DB::raw("SUBSTRING(t.slip_no,1,3)"),'=',$slipOutCode)->first();
            if(isset($test->qty_available)){
                $begining1 = $test->qty_available;
            }
            $test1 = DB::select("select * from (select sum(t2.quantity) as qty, t2.slip_no, t2.transaction_date from transaction as t2 
                     inner join shipment as sh on sh.shipment_id = t2.shipment_id
                     where 1=1 and SUBSTRING(t2.slip_no,1,3) = '".$slipOutCode."'
                     and t2.transaction_type = 2 and sh.shipment_no not like '%".$shipmentNo."%' group by sh.sales_id order by t2.slip_no) a 
                     where a.slip_no < '".$slipOut."' and transaction_date <= '".$transactionDate."'");
                     $begining2 = 0;
                     foreach ($test1 as $key) {
                        $begining2 += $key->qty;

                     }
            $begining = $begining1 - $begining2;
            $ending = $begining - $total_quantity;
            
        @endphp
        @endforeach

    <tr>
        <td>RSB</td>
        <td>{{ $vessel_name }}</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
    </tr>
    <tr>
        <td>GGL</td>
        <td>{{ $vessel_name }}</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        </tr>

        <tr>
        <td>RSB + GGL</td>
        <td>{{ $vessel_name }}</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
        </tr>

        <tr>
        <td>Uncertified</td>
        <td>{{ $row2->vessel_name }}</td>
        <td>{{ number_format($begining, 2, ".", ",") }}</td>
        <td>{{ number_format($total_quantity, 2, ".", ",") }}</td>
        <td>{{ number_format($ending, 2, ".", ",") }}</td>

        <tr>
        <td></td>
        <td>Total</td>
        <td>{{ number_format($begining, 2, ".", ",") }}</td>
        <td>{{ number_format($total_quantity, 2, ".", ",") }}</td>
        <td>{{ number_format($ending, 2, ".", ",") }}</td>
        </tr>
        </tr>
        </tbody>
        </table> --}}
        {{-- <div class="table mt-3 mr-5"> --}}
        <div class="container-fluid">
            <div id="col-md-12">
        <table class="table table-stripped" id="table">
        <thead>
            <tr>
                <td><b>Area</b></td>
                <td><b>Transaction Date</b></td>
                <td><b>Slip No</b></td>
                <td><b>DO No</b></td>
                <td><b>PO No</b></td>
                <td><b>PKS Source</b></td>
                <td><b>Certification</b></td>
                <td><b>Destination (Km)</b></td>
                <td><b>GHG Amount</b></td>
                <td><b>Shipment Code</b></td>
                <td><b>Inventory (Kg)</b></td>
                <td><b>PKS Source Detail</b></td>
                <td><b>Tanggal Masuk</b></td>
                <td><b>Tanggal Muat</b></td>
                <td><b>Kode Masuk Mobil</b></td>
                <td><b>Kode Terima</b></td>
                <td><b>Tiket Timbang</b></td>
                <td><b>Contract No</b></td>
            </tr>
        </thead>
        <tbody>
            @forelse($pks as $row)
            @php
                if($row->slip_no >= 'SAM-0000000001' && $row->slip_no <= 'SAM-0000001925'){
				$fc_pph = 4 ;
			    }else{
				$fc_pph	 = $row->fc_pph;
			    }

			    if($row->slip_no >= 'MAR-0000000001' && $row->slip_no <= 'MAR-0000007138'){
				$fc_pph = 4 ;
			    }else{
				$fc_pph	 = $row->fc_pph;
			    }

		         if($row->vh_pph_tax_category == 1 && $row->vh_pph_tax_id != ''){
			         $pphvh = ($row->handling_total / ((100 - $row->vh_pph) / 100)) - $row->handling_total;

				 }elseif($row->vh_pph_tax_category == 0 && $row->vh_pph_tax_id != ''){
					  $pphvh =  0;
					 //$pphfc =  $row->freight_total - ($row->freight_total * ((100 - $fc_pph) / 100));
				 }else{
				 	$pphvh = 0;
				 }

				 $handlingTotal = $row->handling_total - $pphvh;

		        if($row->fc_pph_tax_category == 1 && $row->fc_pph_tax_id != ''){
			         $pphfc = ($row->freight_total / ((100 - $fc_pph) / 100)) - $row->freight_total;
					 $pphfcShrink = ($row->freight_shrink / ((100 - $fc_pph) / 100)) - $row->freight_shrink;

				 }elseif($row->fc_pph_tax_category == 0 && $row->fc_pph_tax_id != ''){
					  $pphfc =  0;
						$pphfcShrink = 0;
					 //$pphfc =  $row->freight_total - ($row->freight_total * ((100 - $fc_pph) / 100));
				 }else{
				 	$pphfc = 0;
					$pphfcShrink = 0;
				 }
				 /*
				 if($row->fc_ppn_tax_id != ''){
					 $ppnfc = ($row->freight_total * ((100 + $row->fc_ppn) / 100)) - $row->freight_total;
				 }else{
				     $ppnfc = 0;
			     }*/



				 $freightTotal = ($row->freight_total + $pphfc) - ($row->freight_shrink + $pphfcShrink);


				 if($row->uc_pph_tax_category == 1 && $row->uc_pph_tax_id != ''){
			         $pphuc = ($row->unloading_total / ((100 - $row->uc_pph) / 100)) - $row->unloading_total;

				 }elseif($row->uc_pph_tax_category == 0 && $row->uc_pph_tax_id != ''){
					 $pphuc =  0;
					 //$pphuc =  $row->unloading_total - ($row->unloading_total * ((100 - $row->uc_pph) / 100));
				 }else{
				 	$pphuc = 0;
				 }


				 $unloadingTotal = $row->unloading_total + $pphuc;

     			$totalCogs = $row->cogs_amount + $freightTotal + $unloadingTotal + $handlingTotal;
				$ghgAmount = ($row->quantity / 1000) * $row->ghg;
            @endphp
            
            <tr>
                <td>{{ $row->stockpile_name }}</td>
                <td>{{ $row->transaction_date2 }} </td>
            <td>{{ $row->slip_no }} </td>
			<td>{{ $row->permit_no }} </td>
            <td>{{ $row->po_no }} </td>


            <td>{{ $row->vendor_code }} </td>
			<td>{{ $row->sertifikat }} </td>
			<td style="text-align: right;">{{ number_format($row->distance, 0, ".", ",") }} </td>
            <td style="text-align: right;">{{ number_format($ghgAmount, 2, ".", ",") }} </td>
			
            <td>{{ $row->shipment_no }} </td>

            <td style="text-align: right;">{{ number_format($row->quantity, 0, ".", ",") }} </td>
            <td>{{ $row->vendor_curah_name }} </td>
			
			<td>{{ $row->transaction_date2 }} </td>
			<td>{{ $row->tglMuat }} </td>
			<td>{{ $row->kodeMasukMobil }} </td>
			<td>{{ $row->KodeTerima }} </td>
			<td>{{ $row->tiketTimbang }} </td>
			<td>{{ $row->contract_no }} </td>

            </tr>
            @empty
                <tr>
                <td colspan="18" class="text-center">No data. Please select the shipment code first</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
 </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">        
        $('.livesearch').select2({
            placeholder: 'Select shipment',
            ajax: {
                url: '{{ route('search-shipment') }}',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.shipment_code,
                                id: item.sales_id
                            }
                        })
                    };
                },
            }
        });

        $(document).ready(function () {
            var table = $('#table').DataTable({
                dom: 'lfrtBp',
                deferRender: true,
                buttons: [
                    'excelHtml5',
                ],
                "ordering": false,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

        });
    </script>
@endpush