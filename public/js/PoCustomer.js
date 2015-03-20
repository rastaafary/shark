$(document).ready(function () {

    $('.select2').select2();
    $(' .POselect2').select2();

    $('#orderTime').timepicker({
        hourMin: 8,
        hourMax: 16
    });

    $("#purchaseQty").keydown(function (event) {
        if (!(event.keyCode == 8                                // backspace
                || event.keyCode == 9                               // tab
                || event.keyCode == 17                              // ctrl
                || event.keyCode == 46                              // delete
                || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
                || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
                || (event.keyCode >= 96 && event.keyCode <= 105)    // number on keypad
                || (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id))          // ctrl + a, on same control
                ) {
            event.preventDefault();     // Prevent character input
        }
        else {
            prevKey = event.keyCode;
            prevControl = event.currentTarget.id;
        }
    });

    $('#selectPOCustomer').change(function () {
        id = $('#selectPOCustomer').val();      
        $.ajax({
            type: 'GET',
            url: '/po/getIdentifireList',
            data: 'custId=' + id,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $("#oldIdentifire").html('');
                $.each(jason, function (idx, data) {
                       $("#oldIdentifire").append("<option value='" + data.id + "' class='shippingData'>" + data.identifier + "</option>");

                });
            }
        });
    });

    $("#po_cust_order").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/po/getorderlist",
        "aaSorting": [[7, "desc"]],
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
    });
    var t = $("#POCustomer_list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/po/getPoCustomerlist",
        "aaSorting": [[7, "desc"]],
        "order": [[1, 'asc']],
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
    });

    $('#addNew').prop('checked', false);
    $("#newdetails").hide();

//    var data = $("#oldIdentifire").val();
//    if (data == null)
//    {
//        $('#addNew').prop('checked', false);
//        $("#newdetails").hide();
//    }

    //edit pocust
    $('#editQty').blur(function () {
        qty = $('#editQty').attr('value');
        amount = $('#editUnitPrice').val();
        total = qty * amount;
        $('#editAmount').val(total.toFixed(2));
    });
    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('SKU'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/po/add/searchSKU',
        remote: '/po/add/searchSKU/%QUERY'
    });

    bestPictures.initialize();


    $('.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'SKU',
        source: bestPictures.ttAdapter()
    });

    $("#addNew").click(function () {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide())
            ;
    });

    $(".tt-dropdown-menu").click(function () {
        description = $('#searchSKU').val();
        $.ajax({
            type: 'GET',
            url: '/po/getDescription',
            data: 'description=' + description,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $.each(jason, function (idx, data) {
                    $('#searchDescription').val(data.description);
                    $('#unitprice').val(data.cost);
                });
            }
        });
    });

$('#orderDate,#require_date').datepicker({format: "yyyy-mm-dd", todayBtn: true, todayHighlight: true}).on('changeDate', function (ev) {
        $(this).datepicker('hide');
        $(document.activeElement).trigger("blur");
    });

    jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    $("#POCustomer-list").dataTable({
        //"bProcessing": true,
        "bServerSide": false,
        // "sAjaxSource": "",
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

    $("#searchQty").blur(function () {
        divid = $('#searchQty').closest('div').attr('id');
        qty = $('#searchQty').val();
        amount = $("#unitprice").val();
        total = qty * amount;
        $("#amount").val(total);
    });

    $("#addOrder").click(function () {
        $.ajax({
            type: 'post',
            url: '/po/add/order',
            data: 'name=' + "ABC",
            async: false,
            success: function (responce)
            {
                alert("Hi");
            }
        });
    });

    $('#addorder').click(function () {
        cust_id = $('#id').val();
        searchSKU = $('#searchSKU').val();
        searchQty = $('#searchQty').val();
        amount = $('#amount').val();
        $.ajax({
            type: 'GET',
            url: '/po/add/order',
            data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
            async: false,
            headers: {
                'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function (responce)
            {
            }
        });
    });

    var orderNo = 1;

    if (oldOrderData.length > 0) {
        $(oldOrderData).each(function (key, val) {
            var order = [
                {
                    orderNo: orderNo++,
                    orderId: val.order_id,
                    skuId: val.part_id,
                    skuLabel: val.SKU,
                    description: val.description,
                    purchaseQty: val.qty,
                    unitPrice: val.cost,
                    totalPrice: val.amount
                }
            ];
            // Render the Order details
            $("#new-order-template").tmpl(order).appendTo("#purchaseOrderTbl tbody");
        });

    }


    $("#addMoreOrder").click(function (e) {
        if ($('#skuOrder').val() == 0 || $('#skuOrder').val() == '') {
            alert('Please select SKU');
            return false;
        }
        if ($('#purchaseQty').val() == 0 || $('#purchaseQty').val() == '' || parseInt($('#purchaseQty').val()) < 1) {
            alert('Please enter valid Quantity.');
            return false;
        }
        if ($('#updateId').val() !== '0') {
            template = $('#' + $('#updateId').val()).tmplItem();
            console.log(template);
            template.data.skuId = $('#skuOrder').val();
            template.data.skuLabel = $('#skuOrder option:selected').text();
            template.data.description = $('#searchDescription').html();
            template.data.purchaseQty = $('#purchaseQty').val();
            template.data.unitPrice = $('#unitPrice').html();
            template.data.totalPrice = $('#totalPrice').html();
            template.update();
        } else {
            var order = [
                {
                    orderNo: orderNo++,
                    orderId: 0,
                    skuId: $('#skuOrder').val(),
                    skuLabel: $('#skuOrder  option:selected').text(),
                    description: $('#searchDescription').html(),
                    purchaseQty: $('#purchaseQty').val(),
                    unitPrice: $('#unitPrice').html(),
                    totalPrice: $('#totalPrice').html(),
                }
            ];
            // Render the Order details
            $("#new-order-template").tmpl(order).appendTo("#purchaseOrderTbl tbody");
        }

        //reset input order data
        resetInputOrderData();

        //reset total Data
        resetTotalOrderData();

    });

    $('#cancelUpdate').click(function () {
        resetInputOrderData();
    });

    $('#purchaseQty').keyup(function (e) {
        if ($(this).val() == '') {
            $('#totalPrice').html('0');
            return false;
        }
        if ($.isNumeric($(this).val())) {
            tot_price = $('#unitPrice').html() * $(this).val();
            $('#totalPrice').html(tot_price.toFixed(2));
        } else {
            if (e.keyCode !== 8) {
                $('#totalPrice').html('0');
                alert('Please enter only Numeric value.');
            }
        }
    });
    
    jQuery.validator.addMethod("mobileNo", function (value, element) {
        return this.optional(element) || /^[0-9 \-\(\)\+]+$/.test(value);
    }, "Please enter valid mobile no.");

    $('#PoCustomer').validate({
        submitHandler: function (form) {
            orders = [];
            $('tr.newOrderData').each(function () {
                orders.push({
                    'part_id': $(this).find('.sku').attr('id'),
                    'qty': $(this).find('.purchaseQty').html(),
                    'amount': $(this).find('.totalPrice').html(),
                    'orderId': $(this).find('.orderId').val()
                })
            });
            if (orders.length > 0) {
                $('#deleteOrder').val(deleteOrder);
                $('#allOrderData').val(JSON.stringify(orders));
                form.submit();
            } else {
                $('#allOrderData').val('');
                alert('Please select Order');
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
            'identifer': {
                required: true
            },
            'shippingMethod': {
                required: true
            },
            'payment_terms': {
                required: true
            },
            'require_date': {
                required: true
            },
            'PDF': {
                extension: "pdf"
            },
            'Ai': {
                extension: "ai"
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
            'identifer': {
                required: 'Please enter identifer.'
            },
            'shippingMethod': {
                required: 'Please enter shipping method.'
            },
            'payment_terms': {
                required: 'Please enter payment terms.'
            },
            'require_date': {
                required: 'Please enter require date.'
            },
            'PDF': {
                extension: 'Please only upload PFD file.'
            },
            'Ai': {
                extension: 'Please only upload ai file.'
            }
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

    resetTotalOrderData();
});

function resetTotalOrderData() {
    totalQty = 0;
    totalAmout = 0;
    $('tr.newOrderData').each(function () {
        totalQty += parseFloat($(this).find('.purchaseQty').html());
        totalAmout += parseFloat($(this).find('.totalPrice').html());
    });

    $('#totalQuantity').html(totalQty);
    $('#totalAmout').html(totalAmout.toFixed(2));
}

function resetInputOrderData() {
    $('#updateId').val('0');
    $('#skuOrder').select2("val", '');
    $('#addMoreOrder').html('<i class="fa fa-plus"></i> Add');
    $('#cancelUpdate').hide();
    $('#searchDescription').html('');
    $('#purchaseQty').val('0');
    $('#unitPrice').html('');
    $('#totalPrice').html('');

}

function addOrder() {
    cust_id = $('#id').val();
    searchSKU = $('#searchSKU').val();
    searchQty = $('#searchQty').val();
    amount = $('#amount').val();
    $.ajax({
        type: 'POST',
        url: '/po/add/order',
        data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
        async: false,
        headers: {
            'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (responce)
        {
        }
    });
}

function getinfo(element)
{
    $.ajax({
        type: 'GET',
        url: '/po/getDescription',
        data: 'description=' + $(element).attr('value'),
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            $.each(jason, function (idx, data) {
                $('table #searchDescription').html(data.description);
                $('table #unitPrice').html(data.cost);
            });
            $('#purchaseQty').trigger('keyup');
        }
    });
}
var deleteOrder = [];
function removeNewOrder(element)
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        deleteOrder.push($(element).closest('tr.newOrderData').find('.orderId').val());
        $(element).closest('tr.newOrderData').remove();
        resetTotalOrderData();
    } else {
        return false;
    }
}

function editNewOrder(element)
{
    trEle = $(element).closest('tr.newOrderData');
    $('#skuOrder').select2("val", $(trEle).find('.sku').attr('id'));
    $('#updateId').val($(trEle).attr('id'));
    $('#searchDescription').html($(trEle).find('.description').html());
    $('#purchaseQty').val($(trEle).find('.purchaseQty').html());
    $('#unitPrice').html($(trEle).find('.unitPrice').html());
    $('#totalPrice').html($(trEle).find('.totalPrice').html());
    $('#addMoreOrder').html('<i class="fa fa-edit"></i> Update');
    $('#cancelUpdate').show();
}

function pocustEdit(id)
{
    $('#editProductModal').modal('show');
    $.ajax({
        type: 'GET',
        url: '/po/geteditorderlist',
        data: 'id=' + id,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            $.each(jason, function (idx, data) {
                $('#editSKU').val(data.SKU);
                $('#editDescription').val(data.description);
                $('#editQty').val(data.qty);
                $('#editUnitPrice').val(data.cost);
                $('#editAmount').val(data.amount);
                $('#order_id').val(id);
            });
        }
    });

}

//delete pocustomer
function confirmDelete()
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

//Edit Customer
/*function confirmEdit(id) {
    if (confirm("Are You Sure You Want To Edit This Record ?")) {
        return true;
    } else {
        return false;
    }
}*/