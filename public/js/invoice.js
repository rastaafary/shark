$(document).ready(function () {

    var data = $("#oldShippingInfo").val();
    if (data == null)
    {
        $('#addNew').prop('checked', true);
        $("#newdetails").show();
    }
    $("#addNew").click(function () {
        if ($('#addNew').is(':checked') ? $("#newdetails").show() : $("#newdetails").hide())
            ;
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
      /*
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
     
     $('#searchDescription').focus(function () {
     $('#searchSKU').val('');
     });
     
     $(".tt-dropdown-menu").click(function () {
     skuData = $('#searchSKU').val();
     disData = $('#searchDescription').val();
     if (skuData != '') {
     description = skuData;
     $('#searchDescription').val('');
     $("#searchQty").val('');
     } else if (disData != '') {
     description = disData;
     $('#searchSKU').val('');
     $("#searchQty").val('');
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
     
     $("#searchQty").blur(function () {
     qty = $('#searchQty').val();
     amount = $("#unitprice").val();
     total = qty * amount;
     $("#amount").val(total);
     });
     */
});