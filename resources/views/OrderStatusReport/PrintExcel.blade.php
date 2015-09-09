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
        <th>Cust Name</th>
        <th>PO Number</th>
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

    @foreach ($data as $key=>$d)
    <tr>
        <td>{{$key+1}}</td>        
        <td>{{$d->comp_name}}</td>
        <td>{{$d->po_number}}</td>
        <td>{{$d->SKU}}</td>
        <td>{{$d->size_qty}}</td>
        <td>{{$d->require_date}}</td>
        <td>{{$d->estDate}}</td>
        <td>{{$d->qty}}</td>
        <td>{{$d->pcsMade}}</td>
        <td>{{$d->amount}}</td>
        <td>{{$d->pl_status==0?'Open':'Close'}}</td>
        <td>{{$d->production_status}}</td>
    </tr>
    @endforeach
</table>


