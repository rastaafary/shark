$(document).ready(function () {

    $("#user-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/userdata",
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

    $('#birthdate').datepicker({
        format: 'yyyy-mm-dd',        
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

    //add user validation
    $('#addUser').validate({
        rules: {
            'email': {
                required: true,
                email: true
            },
            'password': {
                required: true,
                minlength: 6
            },
            'name': {
                required: true,
                onlyname: true
            },
            'birthdate': {
                required: true
            },
            'mobileno': {
                required: true,
                mobileNo: true
            },
            'position': {
                required: true,
                onlyposition: true
            },
            'role': {
                required: true
            }
        },
        messages: {
            'email': {
                required: 'Please enter Email.',
                email: 'Please enter valid Email.'
            },
            'password': {
                required: 'Please enter password.',
                minlength: 'Please enter minimum 6 characters.'
            },
            'name': {
                required: 'Please enter name.'
            },
            'birthdate': {
                required: 'Please enter birthdate.'
            },
            'mobileno': {
                required: 'Please enter mobileno.'
            },
            'position': {
                required: 'Please enter position.'
            },
            'role': {
                required: 'Please enter role.'
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

   //edit user validation
    $('#editUser').validate({
        rules: {
            'email': {
                required: true,
                email: true
            },
            'name': {
                required: true,
                onlyname: true
            },
            'birthdate': {
                required: true
            },
            'mobileno': {
                required: true,
                mobileNo: true
            },
            'position': {
                required: true,
                onlyposition: true
            }
        },
        messages: {
            'email': {
                required: 'Please enter Email.',
                email: 'Please enter valid Email.'
            },
            'name': {
                required: 'Please enter name.'
            },
            'birthdate': {
                required: 'Please enter birthdate.'
            },
            'mobileno': {
                required: 'Please enter mobileno.'
            },
            'position': {
                required: 'Please enter position.'
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

function confirmEdit(id) {
    if (confirm("Are You Sure You Want To Edit This Record ?")) {
        return true;
    } else {
        return false;
    }
}