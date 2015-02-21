$(document).ready(function () {

    $('#login').validate({
        rules: {
            'email': {
                required: true,
                email:true
            },
            'password': {
                required: true,
            }
        },
        messages: {
            'email': {
                required: 'Please enter email.',
                email:'Please enter valid email'
            },
            'password': {
                required: 'Please enter password.'
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
 