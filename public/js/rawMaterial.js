$(document).ready(function () {





    $("#rawmaterial-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseURL+"/RawMaterialdata",
        "aaSorting": [[7, "desc"]],
        "aoColumnDefs": [
           
          {"bSortable": false, "aTargets": [6, 7]},
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
        mul = $(".two-digits").val() * $(".two-digits1").val();
        $("#bomcost").val(mul.toFixed(2));
    });


   $('.two-digits').keyup(function(){
        if($(this).val().indexOf('.')!=-1){         
            if($(this).val().split(".")[1].length > 2){                
                if( isNaN( parseFloat( this.value ) ) ) return;
                this.value = parseFloat(this.value).toFixed(2);
            }  
         }            
         return this; //for chaining
    });
    
    
   $('.two-digits1').keyup(function(){
        if($(this).val().indexOf('.')!=-1){         
            if($(this).val().split(".")[1].length > 2){                
                if( isNaN( parseFloat( this.value ) ) ) return;
                this.value = parseFloat(this.value).toFixed(2);
            }  
         }            
         return this; //for chaining
    });
    $('.two-digits2').keyup(function(){
        if($(this).val().indexOf('.')!=-1){         
            if($(this).val().split(".")[1].length > 2){                
                if( isNaN( parseFloat( this.value ) ) ) return;
                this.value = parseFloat(this.value).toFixed(2);
            }  
         }            
         return this; //for chaining
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
    $('#addpart').validate({
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
            'partnumber': {
                required: 'Please enter partnumber.'
            },
            'description': {
                required: 'Please enter description.'

            },
            'cost': {
                required: 'Please enter cost.',
                amountValidation: 'Please enter valid cost',
            },
            'purchasingcost': {
                required: 'Please enter purchasingcost.',
                amountValidation: 'Please enter valid purchasing cost',
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
    $('#addpart1').validate({
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


