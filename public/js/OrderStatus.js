$(document).ready(function ()
{
     $('.ESDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true,
    });
    
  /*  $("#order-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/PLReport/orderlist",
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        }
    }); */
});
