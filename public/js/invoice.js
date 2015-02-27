$(document).ready(function () {
    $('.SKUselect2').select2({
        allowClear:true,
    });
    
    var data = $("#oldShippingInfo").val();
    if (data == null)
    {
        $('#addNew').prop('checked', true);
        $("#newdetails").show();
    }
    $("#addNew").click(function () {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide());
    });

    $("#selectPO").change(function () {
        id = $('#selectPO').val();
        $.ajax({
            type: 'GET',
            url: '/invoice/listShipingInfo',
            data: 'id=' + id,
            async: false,
            success: function (responce)
            {
                $('.shippingData').remove();
                var jason = $.parseJSON(responce);
                $.each(jason, function (idx, data) {
                    $("#oldShippingInfo").append("<option val='" + data.identifier + "' class='shippingData'>" + data.identifier + "</option>");
                });
                $("#searchQty").prop("disabled", false);
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
                $("#selectSKU").html(null);
                $("#selectSKU").append($("<option>").val('').html('Select SKU'));
                $.each(jason, function (idx, data) {
                    $("#selectSKU").append($("<option>").val(data.id).html(data.SKU));
                    
                });
            }
        });
        
        $.ajax({
            type: 'GET',
            url: '/invoice/paymentTerm',
            data: 'id=' + id,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);              
                $('#paymentTerm').text(jason.payment_terms);

            }
        });
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

    jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    $('#Invoice').validate({
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
                mobileNo: true
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
                onlyname: true
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
                mobileNo: true
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
                mobileNo: 'Please enter valid phone no.'
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
                onlyname: 'Please enter valid company name.'
            },
            'shpbuilding_no': {
                required: 'Please enter building no.'
            },
            'shpstreet_addrs': {
                required: 'Please enter street address.'
            },
            'shpphone_no': {
                required: 'Please enter phone no.',
                mobileNo: 'Please enter valid phone no.'
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
    
     $("#selectSKU").change(function() {
        if($(this).val() == '' || $(this).val() == '0') {
            return false;
        }
        $.ajax({
            type: 'GET',
            url: '/invoice/dispSKUdata',
            data: {id: $(this).val()},
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $('#description').val(jason.description);
                $('#unitPrice').html(jason.cost);
            }
        });
    });
    
    
    var orderNo = 1;
    $("#vAddMoreOrder").click(function(e) {
        if ($('#skuOrder').val() == 0 || $('#skuOrder').val() == '') {
            alert('Please select SKU');
            return false;
        }
        if ($('#vPurchaseQty').val() == 0 || $('#vPurchaseQty').val() == '') {
            alert('Please enter Quantity.');
            return false;
        }
        if ($('#updateId').val() !== '0') {
            template = $('#'+$('#updateId').val()).tmplItem();
            template.data.skuId = $('#skuOrder').val();
            template.data.skuLabel = $('#skuOrder  option:selected').text();
            template.data.description = $('#vDescription').val();
            template.data.purchaseQty = $('#vPurchaseQty').val();
            template.data.unitPrice = $('#vUnitPrice').html();
            template.data.discount = $('#vDiscount').html();
            template.data.totalPrice = $('#vTotalPrice').html();
            template.update();
        } else {
            var order = [
                {
                    orderNo: orderNo++,
                    skuId: $('#skuOrder').val(),
                    skuLabel:$('#skuOrder  option:selected').text(),
                    description:$('#vDescription').val(),
                    purchaseQty:$('#vPurchaseQty').val(),
                    unitPrice:$('#vUnitPrice').html(),
                    discount:$('#vDiscount').html(),
                    totalPrice:$('#vTotalPrice').html(),
                }
            ];
            // Render the Order details
            $("#new-order-template").tmpl(order).appendTo("#purchaseOrderTbl tbody");
        }
        
        //reset input order data
        resetInputInvoiceData();
        
        //reset total Data
        resetTotalInvoiceData();
        
    });
    
});

function resetTotalInvoiceData() {
    totalQty = 0;
    totalAmout = 0;
    
    $('tr.newInvoiceData').each(function(){
        totalQty += parseInt($(this).find('.purchaseQty').html());
        totalAmout += parseInt($(this).find('.totalPrice').html());
    });

    $('#vTotalQuantity').html(totalQty);
    $('#vTotalAmout').html(totalAmout);
}

function resetInputInvoiceData() {
    $('#updateId').val('0');
    $('#skuOrder').select2("val", '');
    $('#vAddMoreOrder').html('<i class="fa fa-plus"></i> Add');
    $('#vCancelUpdate').hide();
    $('#vDescription').val('');
    $('#vPurchaseQty').val('0');
    $('#vUnitPrice').html('');
    $('#vDiscount').val('');
    $('#vTotalPrice').html('');
    
}

function removeNewOrder(element)
{
    $(element).closest('tr.newInvoiceData').remove();
    resetTotalInvoiceData();
}

function editNewOrder(element)
{
    trEle = $(element).closest('tr.newOrderData');
    $('#skuOrder').select2("val", $(trEle).find('.sku').attr('id'));
    $('#updateId').val($(trEle).find('.sku').attr('id'));
    $('#searchDescription').val($(trEle).find('.description').html());
    $('#purchaseQty').val($(trEle).find('.purchaseQty').html());
    $('#unitPrice').html($(trEle).find('.unitPrice').html());
    $('#totalPrice').html($(trEle).find('.totalPrice').html());
    $('#addMoreOrder').html('<i class="fa fa-edit"></i> Update');
    $('#cancelUpdate').show();
}