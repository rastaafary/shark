$(document).ready(function() {
   
    $("#part-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/partdata",
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
    //cost validation
    jQuery.validator.addMethod("amountValidation", function(value, element) {
            return this.optional(element) || /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
        }, "Please enter valid cost");
    //edit part validation
    $('#editpart').validate({
        rules: {
            'SKU': {
                required: true,
            },
            'description': {
                required: true,
            },
            'cost': {
                required: true,
                amountValidation:true
            }
        },
        messages: {
            'SKU': {
                required: 'Please enter SKU.'
            },
            'description': {
                required: 'Please enter description.'
            },
            'cost': {
                required: 'Please enter cost.'
                
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
    //add part validation
    $('#addpart').validate({
       
        rules: {
            'SKU': {
                required: true,
            },
            'description': {
                required: true,
            },
            'cost': {
                required: true,
                amountValidation:true
            },
        },
        messages: {
            'SKU': {
                required: 'Please enter SKU.'
            },
            'description': {
                required: 'Please enter description.'
            },
            'cost': {
                required: 'Please enter cost.'
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

