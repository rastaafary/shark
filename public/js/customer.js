$(document).ready(function () {

    $("#customer-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseURL+"/customerdata",
        "aoColumnDefs": [
           // {"bSearchable": false, "aTargets": [1,2,3,4,5]},
            {"bSortable": false, "aTargets": [9,10]}
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
        "fnDrawCallback": function (oSettings, json) {
            $("#customer-list th:nth-last-child(1), #customer-list td:nth-last-child(1)").hide();
        }, 
    });
   
    $('#birthdate').datepicker({format: "yyyy-mm-dd", todayBtn: true, todayHighlight: true}).on('changeDate', function (ev) {
        $(this).datepicker('hide');
        $(document.activeElement).trigger("blur");
    });

    jQuery.validator.addMethod("onlyname", function (value, element) {
        return this.optional(element) || /^[a-z A-Z]+$/.test(value);
    }, "Please enter valid name.");

    jQuery.validator.addMethod("mobileNo", function (value, element) {
        return this.optional(element) || /^[0-9 \-\(\)\+]+$/.test(value);
    }, "Please enter valid mobile no.");

    $('#addCustomer').validate({
        rules: {
            'comp_name': {
                required: true,
                onlyname: true
            },
            'zipcode': {
                required: true
            },
            'building_no': {
                required: true,
            },
            'street_addrs': {
                required: true
            },
            'phone_no': {
                required: true,
                mobileNo: true
            },
            
            'city': {
                required: true
            },
            'state': {
                required: true
            },
            'contact_name': {
                required: true,
                onlyname: true
            },
            'position': {
                required: true,
                onlyname: true
            },
            'contact_email': {
                required: true,
                email: true
            },
            'password': {
                required: true,
                minlength: true

            },
            'contact_mobile': {
                required: true,
                mobileNo: true
            },
            'contact_birthdate': {
                required: true
            },
        },
        messages: {
            'comp_name': {
                required: 'Please enter company name.',
                onlyname: 'Please enter valid company name.'
            },
            'password': {
                required: 'Please enter password.',
                minlength: 'Please enter minimum 6 characters.'
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
            
            'city': {
                required: 'Please enter city.'
            },
            'state': {
                required: 'Please enter state.'
            },
            'contact_name': {
                required: 'Please enter contact name.',
                onlyname: 'Please enter valid contact name.'
            },
            'position': {
                required: 'Please enter position.',
                onlyname: 'Please enter valid position.'
            },
            'contact_email': {
                required: 'Please enter contact_email.',
                email: 'Please enter valid email.'
            },
            'contact_mobile': {
                required: 'Please enter contact mobile.',
                mobileNo: 'Please enter valid contact mobile.'
            },
            'contact_birthdate': {
                required: 'Please enter contact birthdate.'
            },
            'zipcode': {
                required: 'Please enter zipcode.'
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

    $('#editCustomer').validate({
        rules: {
            'comp_name': {
                required: true,
                onlyname: true
            },
            'zipcode': {
                required: true
            },
            'building_no': {
                required: true,
            },
            'street_addrs': {
                required: true
            },
            'phone_no': {
                required: true,
                mobileNo: true
            },
            
            'city': {
                required: true
            },
            'state': {
                required: true
            },
            'contact_name': {
                required: true,
                onlyname: true
            },
            'position': {
                required: true,
                onlyname: true
            },
            'contact_email': {
                required: true,
                email: true
            },
            'contact_mobile': {
                required: true,
                mobileNo: true
            },
            'contact_birthdate': {
                required: true
            },
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
           
            'city': {
                required: 'Please enter city.'
            },
            'state': {
                required: 'Please enter state.'
            },
            'contact_name': {
                required: 'Please enter contact name.',
                onlyname: 'Please enter valid contact name.'
            },
            'position': {
                required: 'Please enter position.',
                onlyname: 'Please enter valid position.'
            },
            'contact_email': {
                required: 'Please enter contact_email.',
                email: 'Please enter valid email.'
            },
            'contact_mobile': {
                required: 'Please enter contact mobile.',
                mobileNo: 'Please enter valid contact mobile.'
            },
            'contact_birthdate': {
                required: 'Please enter contact birthdate.'
            },
            'zipcode': {
                required: 'Please enter zipcode.'
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
function confirmDelete(id) {
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

