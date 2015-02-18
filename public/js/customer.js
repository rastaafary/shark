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
    //add user validation
    /*   $('#addUser').validate({
     rules: {
     'email': {
     required: true,
     email: true,
     },
     'password': {
     required: true,
     minlength: 6
     },
     'name': {
     required: true,
     },
     'birthdate': {
     required: true,
     },
     'mobileno': {
     required: true,
     digits: true,
     maxlength: 10,
     minlength: 10
     },
     'position': {
     required: true,
     },
     'role': {
     required: true,
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
     required: 'Please enter mobileno.',
     digits: 'Please enter only Digits.',
     maxlength: 'please enter 10 Digits only.',
     minlength: 'please enter 10 Digits only'
     },
     'position': {
     required: 'Please enter position.'
     },
     'role': {
     required: 'Please enter role.'
     },
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
     }); */
});