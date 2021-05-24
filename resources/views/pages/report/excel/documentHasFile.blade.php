<table id="table" class="table table-responsive">
    <thead>
    <tr>
        <th scope="col">Stockpile</th>
        <th scope="col">Nama PKS</th>
        <th scope="col">Jumlah Document terkumpul</th>
        <th scope="col">Percentage %</th>
        @foreach($categories as $row)
            <th scope="col">{{ $row->name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($documents as $doc)
        <tr>
            <td>{{ $stockpile }}</td>
            <td>{{ $doc->vendor_name }}</td>
            <td>{{ $doc->total_document }}</td>
            <td> {{ $doc->percentage_document }}</td>
            @foreach($categories as $row)
                <td>{{ $doc->checkDocument($row->id, $doc->vendor_id)}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
