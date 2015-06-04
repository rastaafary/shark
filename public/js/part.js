$(document).ready(function () {
//    if(whichPage == 'Edit'){
//            $(".js-example-basic-multiple").select2("val", [1,2,3]);
//    }
// $(".Books_Illustrations").select2("val", ["a", "c"]);
    $("#list-parts").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseURL + "/partdata",
        "aaSorting": [[0, "desc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [4]},
            {"bSortable": false, "aTargets": [4]}
        ],
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

    $('#sourceValues').change(function () {
        $.ajax({
            type: 'GET',
            url: baseURL + '/part/getSizeData',
            data: size,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $("#oldIdentifire").html('');
                $.each(jason, function (idx, data) {

                    var sizeList = ["XS", "S", "M", "L", "XL", "XXL", "XXXL"];
                    sizeList.push(size);
                });
            }
        });
    });


    $(".js-example-basic-multiple").select2({
    placeholder: "Select a Size.."
});    

    $(".js-example-basic-multipled").select2({
    placeholder: "Select a Size.."
});    

//        var selectedValues = new Array();
//selectedValues[4] = "L";
//selectedValues[5] = "XL";
// $(".js-example-basic-multiple").select2(selectedValues);

    //cost validation    
    jQuery.validator.addMethod("amountValidation", function (value, element) {
        return this.optional(element) || /^(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
    }, "Please enter valid cost");

    $.validator.addMethod("alphaNum", function (value, element) {
        return this.optional(element) || /^[a-z0-9\\]+$/i.test(value)
    }, "Please enter valid SKU");

    //edit part validation
    $('#editpart').validate({
        ignore: '.select2-input',
        
        rules: {
            'SKU': {
                required: true,
                alphaNum: true
            },
            'description': {
                required: true,
            },
            'labels[]':{
             required: true,
            },

            'label[]': {
                required: true,
            },
            'cost': {
                required: true,
                amountValidation: true,
            },
            'ai': {
                extension: "ai"
            }
        },
        messages: {
            'SKU': {
                required: 'Please enter SKU.'
            },
            'description': {
                required: 'Please enter description.'
            },
            'labels[]': {
                required: 'Please enter size.'
            },
            'label[]': {
                required: 'Please enter components.'
            },
            'cost': {
                required: 'Please enter cost.'

            },
            'ai': {
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
    //add part validation
    $('#addpart').validate({
        ignore: '.select2-input',
        rules: {
            'SKU': {
                required: true,
                alphaNum: true
            },
            'description': {
                required: true
            },
            'labels[]': {
                ignore: '',
            },
            'label[]': {
                required: true,
            },
            'cost': {
                required: true,
                amountValidation: true
            },
             'ai': {
                extension: "ai"
            }
        },
        messages: {
            'SKU': {
                required: 'Please enter SKU.'
            },
            'description': {
                required: 'Please enter description.'
            },
            'labels[]': {
                required: 'Please enter size.'
            },
            'label[]': {
                required: 'Please enter components.'
            },
            'cost': {
                required: 'Please enter cost.'

            },
            'ai': {
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
});
function confirmDelete()
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

