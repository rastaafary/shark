$(document).ready(function() {
    
    $('#orderTime').timepicker({
        hourMin: 8,
        hourMax: 16
    });
    
    $("#editQty").keydown(function (event) {
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
    
    $("#po_cust_order").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/po/getorderlist",
        "aaSorting": [[7, "desc"]],
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
    var t = $("#POCustomer_list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/po/getPoCustomerlist",
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
   

    var data = $("#oldIdentifire").val();
    if (data == null)
    {
        $('#addNew').prop('checked', true);
        $("#newdetails").show();
    }
    //edit pocust
    $('#editQty').blur(function() {
        qty = $('#editQty').attr('value');
        amount = $('#editUnitPrice').val();
        total = qty * amount;
        $('#editAmount').val(total);
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

    $("#addNew").click(function() {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide())
            ;
    });

    $(".tt-dropdown-menu").click(function() {
        description = $('#searchSKU').val();
        // var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'GET',
            url: '/po/getDescription',
            data: 'description=' + description,
            async: false,
            success: function(responce)
            {
                var jason = $.parseJSON(responce);
                $.each(jason, function(idx, data) {
                    $('#searchDescription').val(data.description);
                    $('#unitprice').val(data.cost);
                });
            }
        });

    });

    $('#require_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });
    $('#orderDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });


    jQuery.validator.addMethod("onlyname", function(value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    $("#POCustomer-list").dataTable({
        //"bProcessing": true,
        "bServerSide": false,
        // "sAjaxSource": "",
        "aaSorting": [[7, "desc"]],
        "fnServerData": function(sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        }
    });

    $("#searchQty").blur(function() {
        divid = $('#searchQty').closest('div').attr('id');
        qty = $('#searchQty').val();
        amount = $("#unitprice").val();
        total = qty * amount;
        $("#amount").val(total);
    });

    $("#addOrder").click(function() {
        $.ajax({
            type: 'post',
            url: '/po/add/order',
            data: 'name=' + "ABC",
            async: false,
            success: function(responce)
            {
                alert("Hi");
            }
        });
    });

    $('#addorder').click(function() {
        cust_id = $('#id').val();
        searchSKU = $('#searchSKU').val();
        // searchDescription = $('#searchDescription').val();
        searchQty = $('#searchQty').val();
        //unitprice = $('#unitprice').val();
        amount = $('#amount').val();
        $.ajax({
            type: 'GET',
            url: '/po/add/order',
            data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
            async: false,
            headers: {
                'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(responce)
            {
            }
        });
    });
    var next = 0;
    $(".add-more").click(function(e) {
        //  alert($(".addpo").html());
        // $("#maindiv").html('<select name="sku" class="sku">'+$('#skudropdown').val())+'</select>');

        var template = $($('#element-template').html());
        next = next + 1;
        $('#maindiv').append(template.clone().attr('id', 'addpo' + next));
        $('#addpo'+next+' .select2').select2();
        // $("#maindiv").append($(".addpo").html());
        //  $(".addpo").html()
    });



    $('#PoCustomer').validate({
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
                required: true
            },
            'Ai': {
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
                required: 'Please upload PFD.'
            },
            'Ai': {
                required: 'Please upload ai.'
            }
        },
        highlight: function(element) {
            $(element).removeClass("textinput");
            $(element).addClass("errorHighlight");
        },
        unhighlight: function(element) {
            $(element).removeClass("errorHighlight");
            $(element).addClass("textinput");
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });


});
function addOrder() {
    cust_id = $('#id').val();
    searchSKU = $('#searchSKU').val();
    // searchDescription = $('#searchDescription').val();
    searchQty = $('#searchQty').val();
    //unitprice = $('#unitprice').val();
    amount = $('#amount').val();
    $.ajax({
        type: 'POST',
        url: '/po/add/order',
        data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
        async: false,
        headers: {
            'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(responce)
        {
        }
    });
}

function getinfo(element)
{
    sku = $(element).attr('value');
    divid = $(element).closest('.addpo').attr('id');

    // sku = $('#sku').val();
    $.ajax({
        type: 'GET',
        url: '/po/getDescription',
        data: 'description=' + sku,
        async: false,
        success: function(responce)
        {
            var jason = $.parseJSON(responce);
            $.each(jason, function(idx, data) {
                $('#' + divid + ' #searchDescription').val(data.description);
                $('#' + divid + ' #unitprice').val(data.cost);
                //$(element).closest('div')
                //$('#unitprice').val(data.cost);
            });
        }
    });
    // alert($(element).attr('value'));
    //$('div').closest('.addpo').remove();
}

function calAmount(element)
{
    divid = $(element).closest('.addpo').attr('id');
    sku = $('#' + divid + ' #sku').val();
    if (sku > 0) {
        qty = $(element).attr('value');
        //  divid = $(element).closest('div').attr('id');
        amount = $('#' + divid + ' #unitprice').val();
        total = qty * amount;
        $('#' + divid + ' #amount').val(total);
    } else {
        alert('fisrt select sku');
    }
}

function removediv(element)
{
    divid = $(element).closest('.addpo').attr('id');
    $('#' + divid).remove();
}

function pocustEdit(id)
{
    $('#editProductModal').modal('show');
    $.ajax({
        type: 'GET',
        url: '/po/geteditorderlist',
        data: 'id=' + id,
        async: false,
        success: function(responce)
        {
            var jason = $.parseJSON(responce);
            $.each(jason, function(idx, data) {
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
function edValueKeyPress(event)
{
      if( !(event.keyCode == 8                                // backspace
        || event.keyCode == 46                              // delete
        || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
        || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
        || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
        ) {
            event.preventDefault();     // Prevent character input
    }
}