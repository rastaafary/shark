<style>
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>
<table>

    <tr>
        <th>Seq</th>
        <th>PO Number</th>
        <th>Cust Name</th>
        <th>Part Number</th>        
        <th>Size Qty</th>
        <th>Req Date</th>
        <th>Est Ship Date</th>
        <th>PO Qty</th>
        <th>Pcs Made</th>
        <th>Balance</th>
        <th>Status</th>
        <th>Pro Status</th>
    </tr>
    @foreach ($data as $d)
    <tr>
        <td>{{$d->sequence}}</td>
        <td>{{$d->po_number}}</td>
        <td>{{$d->comp_name}}</td>
        <td>{{$d->SKU}}</td>
        <td>{{$d->size_qty}}</td>
        <td>{{$d->require_date}}</td>
        <td>{{$d->estDate}}</td>
        <td>{{$d->qty}}</td>
        <td>{{$d->pcsMade}}</td>
        <td>{{$d->amount}}</td>
        <td>{{$d->pl_status}}</td>
        <td>{{$d->production_status}}</td>
    </tr>
    @endforeach
</table>


