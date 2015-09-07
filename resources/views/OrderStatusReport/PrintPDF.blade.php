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
        <th>{{$d->sequence}}</th>
        <th>{{$d->po_number}}</th>
        <th>{{$d->comp_name}}</th>
        <th>{{$d->SKU}}</th>
        <th>{{$d->size_qty}}</th>
        <th>{{$d->require_date}}</th>
        <th>{{$d->estDate}}</th>
        <th>{{$d->qty}}</th>
        <th>{{$d->pcsMade}}</th>
        <th>{{$d->amount}}</th>
        <th>{{$d->pl_status}}</th>
        <th>{{$d->production_status}}</th>
    </tr>
    @endforeach
</table>


