$(document).ready(function() {

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

    $('.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'SKU',
        source: bestPictures.ttAdapter()
    });


    /*
     $("#btnSubmit").click(function () {
     
     if ($('#addNew').is(':unchecked'))
     {
     var data = $("#oldIdentifire").val();
     if (data == null)
     {
     alert("Please Enter Address Details");
     $('#addNew').focus();
     return false;
     }
     }
     });*/
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


    // $('#searchSKU').select2();
    /*  $("#searchSKU").keyup(function () {
     name = $("#searchSKU").val();
     // alert(data);
     $.ajax({
     type: 'GET',
     url: '/po/add/searchSKU',
     data: 'name=' + name,
     async: false,
     success: function (responce)
     {
     
     var availableTags = [];
     var jason = $.parseJSON(responce);
     $.each(jason, function (k, data) {
     //var availableTags[k] = data.SKU;
     data.value = data.SKU;
     availableTags.push(data);
     
     });
     //  alert(availableTags);
     //alert(availableTags);
     
     
     /*   $("#searchSKU").autocomplete()
     .data("ui-autocomplete")._renderItem = function (ul, item) {
     return $("<li></li>")
     .data("item.autocomplete", item)
     //instead of <span> use <a>
     .append("<a class='" + item.id + "'></a><a>" + item.value + "</a>")
     .appendTo(ul);
     };
     */

    /*         $("#searchSKU").autocomplete({
     
     source: availableTags,
     minLength: 0,
     focus: function (event, ui) {
     $('.post-to').val(ui.item.value);
     alert(ui.item.value);
     return true;
     },
     select: function (event, ui) {
     alert(ui.item.value);
     return false;
     }
     
     }).data("ui-autocomplete")._renderItem = function (ul, item) {
     return $("<li></li>")
     .data("item.autocomplete", item)
     .append("<a class='" + item.id + "'></a><a>" + item.value + "</a>")
     .appendTo(ul);
     };
     
     /*   var availableTags = [
     "ActionScript",
     "AppleScript",
     "Asp",
     "BASIC",
     "C",
     "C++",
     "Clojure",
     "COBOL",
     "ColdFusion",
     "Erlang",
     "Fortran",
     "Groovy",
     "Haskell",
     "Java",
     "JavaScript",
     "Lisp",
     "Perl",
     "PHP",
     "Python",
     "Ruby",
     "Scala",
     "Scheme"
     ];
     
     $("#searchSKU").autocomplete({
     source: availableTags
     });
     
     
     /*
     $.each(jason, function (k, data) {
     $("#searchDescription").val(data.SKU);
     });
     // $("#searchDescription").val(responce);*/
    /*     }
     });
     
     });*/



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