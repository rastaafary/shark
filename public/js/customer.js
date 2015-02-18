$(document).ready(function () {

    $("#customer-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/customerdata",
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

    $('#birthdate').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,
    });
    
     jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");
    
    jQuery.validator.addMethod("onlyposition", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid position.");
    
    jQuery.validator.addMethod("mobileNo", function (value, element) {
        return this.optional(element) || /^[0-9 \-\(\)\+]+$/.test(value);
    }, "Please enter valid mobile no.");

});
