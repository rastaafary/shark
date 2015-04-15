$(document).ready(function () {

    $("#rawmaterial-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/RawMaterialdata",
        "aaSorting": [[7, "desc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [3]},
            {"bSortable": false, "aTargets": [2, 3]}
            //   {"className": "part_no", "aTargets": [1]}
        ],
        // "aoColumns": [{className: "my_class"}, null, null, null, null, null, null, null],
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
    $("#equivalency").blur(function () {
        $("#bomcost").val($("#purchasingcost").val() * $("#equivalency").val());
    });
    jQuery(function ($) {
        $("#product").mask("aaa-aaa-9999");
        $(".part_id").mask("aaa-aaa-9999");
    });
    $("#product").blur(function () {
        $("#product").val($("#product").val().toUpperCase());
    });

    //cost validation    
    jQuery.validator.addMethod("amountValidation", function (value, element) {
        return this.optional(element) || /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
    }, "Please enter valid cost");
    $.validator.addMethod("alphaNum", function (value, element) {
        return this.optional(element) || /^[a-z0-9\\]+$/i.test(value)
    }, "Please enter valid SKU");
    //edit part validation
    $('#editpart').validate({
        rules: {
            'partnumber': {
                required: true,
            },
            'description': {
                required: true,
            },
            'cost': {
                required: true,
                amountValidation: true,
            },
            'purchasingcost': {
                required: true,
                amountValidation: true,
            },
            'equivalency': {
                required: true,
                amountValidation: true,
            },
        },
        messages: {
            'description': {
                required: 'Please enter description.'
            },
            'partnumber': {
                required: 'Please enter partnumber.'
            },
            'cost': {
                required: 'Please enter cost.',
                amountValidation: 'Please enter valid cost',
            },
            'purchasingcost': {
                required: 'Please enter purchasingcost.',
             //   amountValidation: 'Please enter valid purchasing cost',
            },
            'equivalency': {
                required: 'Please enter equivalency.',
              //  amountValidation: 'Please enter valid equivalency',
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
    //add part validation
    $('#addpart').validate({
        rules: {
            'SKU': {
                required: true,
                alphaNum: true
            },
            'description': {
                required: true
            },
            'cost': {
                required: true,
                amountValidation: true
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
function confirmDelete()
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

