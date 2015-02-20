$(document).ready(function () {
    $("#POCustomer-list").dataTable({
        //"bProcessing": true,
        "bServerSide": false,
       // "sAjaxSource": "",
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
});