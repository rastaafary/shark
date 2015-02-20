$(document).ready(function () {
  //  alert("Hi");

    $('#frmForgotPassword').validate({
        rules: {
            'email': {
                required: true,
                email: true
            }
        },
        messages: {
            'email': {
                required: 'Please enter email.',
                email: 'Please enter valid email.'
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
    
     $('#frmResetPassword').validate({
        rules: {
            'password': {
                required: true                
            },
            'repassword': {
                required: true                
            }
        },
        messages: {
            'password': {
                required: 'Please enter password.'                
            },
            'repassword': {
                required: 'Please retype password.'
               
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

