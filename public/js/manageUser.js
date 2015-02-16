$(document).ready(function() {
   
    $("#dynamic-table").dataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "http://localhost.shark/userList",
        "order": [[0, 'desc']],
        "columnDefs": [{
                "targets": 4,
                orderable: false
            }]
    });
    
    //add user validation
    $('#addUser').validate({
        rules: {
            'email': {
                required: true,
            },
            'password': {
                required: true,
            },
            'name': {
                required: true,               
            },
            'birthdate': {
                required: true,
            },
            'mobileno': {
                required: true,
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
                required: 'Please enter Email.'
            },
            'password': {
                required: 'Please enter password.'
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
            },
        },
        highlight: function(element) {
            $(element).removeClass("textinput");
            $(element).addClass("errorHighlight");
        },
        unhighlight: function(element) {
            $(element).removeClass("errorHighlight");
            $(element).addClass("textinput");
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
   
});

