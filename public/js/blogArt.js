$(document).ready(function () {
    var next = 0;
    $(".add-Onemore").click(function (e) {      

        var template = $($('#element-template').html());
        next = next + 1;
        $('#maindiv').append(template.clone().attr('id', 'addpo' + next));
       
    });
   
    $('#frmBlogArt').validate({
        rules: {
            'txtMessage': {
                required: true
            }
        },
        messages: {
            'txtMessage': {
                required: 'Please enter Message.'
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
function removediv(element)
{
    divid = $(element).closest('div').attr('id');
    $('#' + divid).remove();
}