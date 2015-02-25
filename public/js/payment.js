$(document).ready(function () {

    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('contact_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/payment/searchCustomer',
        remote: '/payment/searchCustomer/%QUERY'
    });

    bestPictures.initialize();

    $('#searchCustomer.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'contact_name',
        source: bestPictures.ttAdapter()
    });


    $(".tt-dropdown-menu").click(function () {
        custData = $('#searchCustomer').val();

        // var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'GET',
            url: '/payment/getCustInvoice',
            data: 'custData=' + custData,
            async: false,
            success: function (responce)
            {/*
                var jason = $.parseJSON(responce);
                $.each(jason, function (idx, data) {
                    $('#searchSKU').val(data.SKU);
                    $('#searchDescription').val(data.description);
                    $('#unitprice').val(data.cost);
                });
                $("#searchQty").prop("disabled", false);*/
            }
        });
    });



    $('#require_date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });


    jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    $("#payment-list").dataTable({
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

    /*  $('#PoCustomer').validate({
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
     });*/
});