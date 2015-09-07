<div class="container">
    <!-- Company Details-->
    <table style='border: 0px'>
        <thead>
            <tr>
                <th><img src="{!!url('/')!!}/images/logo.png"></th>
                <th align='left'>SHARK SPORTSWEAR S DE RL DE<br>CV</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($cust))
            <tr>            
                <td>
                    <b>ROMANO 13525 INT.L FRACC.ALCALA</b><br>
                    <b>TIJUANA,B.C. CP22106</b><br><br>
                    <b>Tel:(664) 104-1485</b>
                </td>
                <td style="border: 1px black solid">
                    <b>INVOICE:</b>{{$invoiceOrder->invoice_no}}<br>
                    <b>DATE:</b>{{$invoiceOrder->created_at}}<br>
                    <b>PO REFERENT:</b>{{$invoiceOrder->po_number}}<br>
                </td>
            </tr>
            @endif
        </tbody>

    </table>
    <br>
    <!-- Customer Details-->
    <table>
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($cust))
            <tr>            
                <td>
                    {{$cust->street_addrs}}<br>
                    {{$cust->city}}-{{$cust->state}}<br>
                    {{$cust->country}}
                </td>
                <td>
                    <b>Phone:</b>{{$cust->phone_no}}<br>
                    <b>Fax:</b><br>
                    <b>Tax ID:</b><br>
                </td>
            </tr>
            @endif
        </tbody>

    </table>
    <br>
    <!-- Order Details-->
    <table class="order-details">
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Description</th>
                <th>PO Referent</th>
                <th>Unit Price</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            @foreach($invoiceSKUOrder as $order)
            <tr>
                <td align='right'>{{$order->qty}}</td>
                <td>{{$order->cost}}</td>
                <td>{{$order->description}}</td>
                <td>{{$invoiceOrder->po_number}}</td>
                <td>{{$order->cost}}</td>
                <td align='right'>{{$order->amount}}<?php $total+=$order->amount ?></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan='5' align="right">Total:</th>
                <td align='right'>{{$total}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<style>
    .container{
        width: 500px;
    }
    .container table{
        width: 100%;
        border: 1px black solid;
    }  

    .container .order-details thead{
        background-color: gray;
    }
</style>