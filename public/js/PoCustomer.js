$(document).ready(function () {

    var data = $("#oldIdentifire").val();
    if (data == null)
    {
        $('#addNew').prop('checked', true);
        $("#newdetails").show();
    }

    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('SKU'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/po/add/searchSKU',
        remote: '/po/add/searchSKU/%QUERY'
    });

    bestPictures.initialize();

    $('#searchSKU.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'SKU',
        source: bestPictures.ttAdapter()
    });

    var bestPics = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('description'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/po/add/searchDiscription',
        remote: '/po/add/searchDiscription/%QUERY'
    });

    bestPics.initialize();

    $('#searchDescription.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'description',
        source: bestPics.ttAdapter()
    });

    $("#addNew").click(function () {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide())
            ;
    });
    $('#searchDescription').focus(function(){
        $('#searchSKU').val('');
    });
    

    $(".tt-dropdown-menu").click(function () {
        skuData = $('#searchSKU').val();
        disData = $('#searchDescription').val();
        if (skuData != '') {
            description = skuData;
            $('#searchDescription').val('');
        } else if (disData != '') {
            description = disData;
            $('#searchSKU').val('');
        }
        // var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'GET',
            url: '/po/getDescription',
            data: 'description=' + description,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $.each(jason, function (idx, data) {
                     $('#searchSKU').val(data.SKU);
                    $('#searchDescription').val(data.description);
                    $('#unitprice').val(data.cost);
                });
                $("#searchQty").prop("disabled", false);
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