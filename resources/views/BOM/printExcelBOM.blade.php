
<table>
    <tr>
        <td colspan="3"><img src="images/logo.png"></td>
        <th colspan="3" align='center'>Bill of materialas</th>
    </tr>
    <tr>
        <td colspan="3"></td>
        <th>SKU:</th>
        <td colspan="2">{{ $partinfo[0]->SKU }}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <th>Description:</th>
        <td colspan="2">{{ $partinfo[0]->description }}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <th>Price:</th>
        <td colspan="2">{{ $partinfo[0]->cost }}</td>
    </tr>   
    <tr>
        <th>Part number</th>
        <th>Description</th>
        <th>Cost</th>
        <th>unit</th>
        <th>Yield</th>
        <th>Total</th>
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
        <th colspan="5" align="right">Total :</th>
        <td colspan="1" align="right"> {{ $total }}</td>
    </tr>
</table>