var t_qty = 0;
var tm_qty = 0;
var sku_id = 0;
var tmp_qty = [];
var tot_qty = [];
$(document).ready(function () {
    
    //Get Invoice List 
    $("#invoiceList").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/invoice/getInvoiceList",
        "aaSorting": [[7, "desc"]],
        "order": [[ 1, 'asc' ]],
        "fnServerData": function(sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
    });
    
    $('.SKUselect2').select2({
        allowClear: true,
    });

    var data = $("#oldShippingInfo").val();
    
    if (data == null) {
        $('#addNew').prop('checked', true);
        $("#newdetails").show();
    }
    
    $("#addNew").click(function () {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide());
    });
    
    if (shippingId > 0) {
        getPocustomerData();
    }
    
    $("#po_id").change(function () {
        getPocustomerData();
    });

    $('#vPurchaseQty').keyup(function (e) {
        if ($(this).val() == '') {
            $('#vTotalPrice').html('0');
            return false;
        }
        if ($.isNumeric($(this).val())) {
            tot_price = $('#vUnitPrice').html() * $(this).val();
            $('#vTotalPrice').html(tot_price.toFixed(2));
        } else {
            if (e.keyCode !== 8) {
                $('#vTotalPrice').html('0');
                alert('Please enter only Numeric value.');
            }
        }
    });
    
    $('#vDiscount').keyup(function (e) {
        if ($.isNumeric($(this).val())) {
            tot_price = ($('#vUnitPrice').html() * $('#vPurchaseQty').val()) - ((($('#vUnitPrice').html() * $('#vPurchaseQty').val()) * $(this).val()) / 100);
            $('#vTotalPrice').html(tot_price.toFixed(2));
        } else {
            if (e.keyCode !== 8) {
                $('#vTotalPrice').html('0');
                alert('Please enter only Numeric value.');
            }
        }
    });

    $("#Invoice-list").dataTable({
        "bProcessing": true,
        "bServerSide": false,
        "sAjaxSource": "",
        "aaSorting": [[7, "desc"]],
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        }
    });
    
    $("#skuOrder").change(function () {
        if ($(this).val() == '' || $(this).val() == '0') {
            resetInputInvoiceData();
            return false;
        }
        po_id = $('#po_id').val();
        $.ajax({
            type: 'GET',
            url: '/invoice/dispSKUdata',
            data: {id: $(this).val(), po_id: po_id},
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $.each(jason, function (idx, data) {
                    $('#vDescription').val(data.description);
                    $('#vUnitPrice').html(data.cost);
                });
            },
        });
    });

    var orderNo = 1;
    
    if (oldOrderData.length > 0) {
        console.log(oldOrderData);
        $(oldOrderData).each(function(key,val){
            var order = [
                {
                    orderNo: orderNo++,
                    invoiceOrderId:val.invoiceOrderId,
                    skuId: val.id,
                    purchaseOrderId:val.order_id,
                    skuLabel: val.SKU,
                    description: val.description,
                    purchaseQty: val.qty,
                    unitPrice: val.cost,
                    discount: val.discount,
                    totalPrice: val.amount
                }
            ];
            // Render the Order details
            $("#InvoiceOrderTemplate").tmpl(order).appendTo("#invoiceProductTbl tbody");
        }); 
        resetTotalInvoiceData();
    }
    
    $("#vAddMoreOrder").click(function (e) {
        if ($('#skuOrder').val() == 0 || $('#skuOrder').val() == '') {
            alert('Please select SKU');
            return false;
        }
        
        if ($('#vPurchaseQty').val() == 0 || $('#vPurchaseQty').val() == '' || $('#vPurchaseQty').val() < 1) {
            alert('Please enter valid Quantity.');
            return false;
        }
        
        if ($('#vDiscount').val() > 100) {
            alert('Please enter valid Discount.');
            return false;
        }
        
        if ($('#updateId').val() !== '0') {
            tmp_qty[$('#skuOrder').val()] = tmp_qty[$('#skuOrder').val()] - parseInt(t_qty);
            tmp_qty[$('#skuOrder').val()] += parseInt($('#vPurchaseQty').val());
            
            if (tmp_qty[$('#skuOrder').val()] > tot_qty[$('#skuOrder').val()]) {
                tmp_qty[$('#skuOrder').val()] -= parseInt($('#vPurchaseQty').val());
                alert("Qty should not be more than total Qty");
                return false;
            } else {
                template = $('#' + $('#updateId').val()).tmplItem();
                template.data.skuId = $('#skuOrder').val();
                template.data.purchaseOrderId = $('#skuOrder  option:selected').attr('orderid'),
                template.data.skuLabel = $('#skuOrder  option:selected').text();
                template.data.description = $('#vDescription').val();
                template.data.purchaseQty = $('#vPurchaseQty').val();
                template.data.unitPrice = $('#vUnitPrice').html();
                template.data.discount = $('#vDiscount').val();
                template.data.totalPrice = $('#vTotalPrice').html();
                template.update();
            }
        } else {
            tmp_qty[$('#skuOrder').val()] += parseInt($('#vPurchaseQty').val());
            
            if (tmp_qty[$('#skuOrder').val()] > tot_qty[$('#skuOrder').val()])
            {
                tmp_qty[$('#skuOrder').val()] -= parseInt($('#vPurchaseQty').val());
                alert("Qty should not be more than total Qty");
                return false;
            } else {
                var order = [
                    {
                        orderNo: orderNo++,
                        skuId: $('#skuOrder').val(),
                        invoiceOrderId:0,
                        purchaseOrderId:$('#skuOrder  option:selected').attr('orderid'),
                        skuLabel: $('#skuOrder  option:selected').text(),
                        description: $('#vDescription').val(),
                        purchaseQty: $('#vPurchaseQty').val(),
                        unitPrice: $('#vUnitPrice').html(),
                        discount: $('#vDiscount').val(),
                        totalPrice: $('#vTotalPrice').html(),
                    }
                    //  $("#skuOrder").removeAttr()
                ];
                // Render the Order details
                $("#InvoiceOrderTemplate").tmpl(order).appendTo("#invoiceProductTbl tbody");
            }
        }

        //reset input order data
        resetInputInvoiceData();

        //reset total Data
        resetTotalInvoiceData();

    });

    $('#vCancelUpdate').click(function () {
        resetInputInvoiceData();
    });
    
    jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    $('#Invoice').validate({
        submitHandler: function(form){
            orders = [];
            $('tr.newInvoiceData').each(function(){
                orders.push({
                    'part_id':$(this).find('.sku').attr('id'),
                    'orderId':$(this).find('.sku').attr('orderid'),
                    'invoiceOrderId':$(this).find('.sku').attr('invoiceOrderId'),
                    'qty':$(this).find('.purchaseQty').html(),
                    'amount':$(this).find('.totalPrice').html(),
                    'discount':$(this).find('.discount').html()
                });
            });
            
            if(orders.length > 0) {
                $('#deleteOrder').val(deleteOrder);
                $('#allOrderData').val(JSON.stringify(orders));
                form.submit();

            } else {
                $('#allOrderData').val('');
                alert('Please select Order.');
                return false;
            }            
        },
        rules: {
            'comp_name': {
                required: true,
                onlyname: true
            },
            'zipcode': {
                required: true
            },
            'building_no': {
                required: true
            },
            'street_addrs': {
                required: true
            },
            'phone_no': {
                required: true,
                number:true
                //mobileNo: true
            },
            'interior_no': {
                required: true
            },
            'city': {
                required: true
            },
            'state': {
                required: true
            },
            'shpcomp_name': {
                required: true,
                //onlyname: true
            },
            'shpzipcode': {
                required: true
            },
            'shpbuilding_no': {
                required: true
            },
            'shpstreet_addrs': {
                required: true
            },
            'shpphone_no': {
                required: true,
                number:true
                //mobileNo: true
            },
            'shpinterior_no': {
                required: true
            },
            'shpcity': {
                required: true
            },
            'shpstate': {
                required: true
            }

        },
        messages: {
            'comp_name': {
                required: 'Please enter company name.',
                onlyname: 'Please enter valid company name.'
            },
            'building_no': {
                required: 'Please enter building no.'
            },
            'street_addrs': {
                required: 'Please enter street address.'
            },
            'phone_no': {
                required: 'Please enter phone no.',
                number: 'Please enter valid phone no.'
            },
            'interior_no': {
                required: 'Please enter interior no.'
            },
            'city': {
                required: 'Please enter city.'
            },
            'state': {
                required: 'Please enter state.'
            },
            'zipcode': {
                required: 'Please enter zipcode.'
            },
            'shpcomp_name': {
                required: 'Please enter company name.',
                //onlyname: 'Please enter valid company name.'
            },
            'shpbuilding_no': {
                required: 'Please enter building no.'
            },
            'shpstreet_addrs': {
                required: 'Please enter street address.'
            },
            'shpphone_no': {
                required: 'Please enter phone no.',
                number: 'Please enter valid phone no.'
            },
            'shpinterior_no': {
                required: 'Please enter interior no.'
            },
            'shpcity': {
                required: 'Please enter city.'
            },
            'shpstate': {
                required: 'Please enter state.'
            },
            'shpzipcode': {
                required: 'Please enter zipcode.'
            },
        },
        highlight: function (element) {
            $(element).removeClass("textinput");
            $(element).addClass("errorHighlight");
        },
        unhighlight: function (element) {
            $(element).removeClass("errorHighlight");
            $(element).addClass("textinput");
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        }
    });

});

function resetTotalInvoiceData() {
    totalQty = 0;
    totalAmout = 0;

    $('tr.newInvoiceData').each(function () {
        totalQty += parseInt($(this).find('.purchaseQty').html());
        totalAmout += parseInt($(this).find('.totalPrice').html());
    });
    
    $('#vTotalAmout').html(totalAmout.toFixed(2));
    $('#vTotalQuantity').html(totalQty);
}

function resetInputInvoiceData() {
    $('#updateId').val('0');
    $('#skuOrder').select2("val", '');
    $('#vAddMoreOrder').html('<i class="fa fa-plus"></i> Add');
    $('#vCancelUpdate').hide();
    $('#vDescription').val('');
    $('#vPurchaseQty').val('0');
    $('#vUnitPrice').html('0');
    $('#vDiscount').val('0');
    $('#vTotalPrice').html('0');

}
var deleteOrder = [];
function removeNewOrder(element)
{
    trEle = $(element).closest('tr.newInvoiceData');
    sku_id = trEle.find('.sku').attr('id');
    tm_qty = trEle.find('.purchaseQty').html();
    tmp_qty[sku_id] -= parseInt(tm_qty);
    deleteOrder.push(trEle.find('.sku').attr('invoiceorderid'));
    trEle.remove();
    resetTotalInvoiceData();
}

//delete Invoice
function confirmDelete()
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

//Edit Invoice
function confirmEdit(id) {
    if (confirm("Are You Sure You Want To Edit This Record ?")) {
        return true;
    } else {
        return false;
    }
}

function getPocustomerData() {
    id = $('#po_id').val();
        $.ajax({
            type: 'GET',
            url: '/invoice/listShipingInfo',
            data: 'id=' + id,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $('.shippingData').remove();
                $.each(jason, function (idx, data) {
                    $('#req_date').text(data.require_date);
                    $('#payment_terms').text(data.payment_terms);
                    $("#oldShippingInfo").append("<option value='" + data.id + "' class='shippingData'>" + data.identifier + "</option>");
                });
                if (shippingId > 0) {
                    $('#addNew').prop('checked',false);
                    $('#newdetails').hide();
                    $("#oldShippingInfo").val(shippingId);
                }
            }
        });

        $.ajax({
            type: 'GET',
            url: '/invoice/listSKU',
            data: 'id=' + id,
            async: false,
            success: function (responce)
            {
                $('.skuData').remove();
                var jason = $.parseJSON(responce);
                $("#skuOrder").html(null);
                $("#skuOrder").append($("<option>").val('').html('Select SKU'));
                $.each(jason, function (idx, data) {
                    $("#skuOrder").append($("<option>").val(data.id).attr('orderid',data.orderId).html(data.SKU));
                    if (data.id != '' || data.id != null) {
                        tmp_qty[data.id] = 0;
                        tot_qty[data.id] = data.qty;
                    }
                });
            }
        });
}

function editNewOrder(element)
{
    trEle = $(element).closest('tr.newInvoiceData');
    $('#skuOrder').select2("val", $(trEle).find('.sku').attr('id'));
    $('#updateId').val($(trEle).attr('id'));
    $('#vDescription').val($(trEle).find('.description').html());
    $('#vPurchaseQty').val($(trEle).find('.purchaseQty').html());
    $('#vUnitPrice').html($(trEle).find('.unitPrice').html());
    $('#vDiscount').val($(trEle).find('.discount').html());
    $('#vTotalPrice').html($(trEle).find('.totalPrice').html());
    $('#vAddMoreOrder').html('<i class="fa fa-edit"></i> Update');
    $('#vCancelUpdate').show();
    t_qty = parseInt($('#vPurchaseQty').val());
}