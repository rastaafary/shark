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
        <td rowspan="4" colspan="3"><img src="{!!url('/')!!}/images/logo.png"></td>
        <td colspan="3"><center><b>Bill of materialas</b></center></td>
    </tr>
    <tr colspan="">
        <td><b>SKU:</b></td>
        <td colspan="2">{{ $partinfo[0]->SKU }}</td>
    </tr>
    <tr colspan="" rowspan="2">
        <td><b>Description:</b></td>
        <td colspan="2">{{ $partinfo[0]->description }}</td>
    </tr>
    <tr colspan="2" rowspan="2">
        <td><b>Price:</b></td>
        <td colspan="2">{{ $partinfo[0]->cost }}</td>
    </tr>   
</tr>  



<tr>
    <td><b>Part number</b></td>
    <td><b>Description</b></td>
    <td><b>Cost</b></td>
    <td><b>unit</b></td>
    <td><b>Yield</b></td>
    <td><b>Total</b></td>
</tr>
@foreach ($bomlist as $bomitem)
<tr>
    <td>{{ $bomitem->partnumber }}</td>
    <td>{{ $bomitem->description }}</td>
    <td>{{ $bomitem->bomcost }}</td>
    <td>{{ $bomitem->name }}</td>
    <td>{{ $bomitem->yield }}</td>
    <td>{{ $bomitem->total }}</td>
</tr>
@endforeach
<tr>
    <td colspan="5" align="right"><b>Total :</b></td>
    <td colspan="1"> {{ $total }}</td>
</tr>
</table>


