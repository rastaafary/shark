$(document).ready(function()
{
    // Set datepicker
    $('.ESDate,#pcsMadeDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        todayHighlight: true
    });

    // Set datatable
    $("#order-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/PLReport/orderlist",
        "aaSorting": [[0, "asc"]],
        /*"aoColumnDefs": [
         {"bSearchable": false, "aTargets": [0]},
         {"bSortable": false, "aTargets": [0]}
         ],*/
        "fnServerData": function(sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
        "fnDrawCallback": function(oSettings, json) {
            $('.ESDate').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayBtn: true,
                todayHighlight: true
            });
        }
    });

    // Change status of PL's
    $('body').delegate('#order-list #plStatusChange', 'change', function() {
        changePlValues($(this).attr('olId'), 'pl_status', $(this).val());
    });

    // On shipping date change
    $('body').delegate('#order-list #ESDate', 'focusout', function() {
        changePlValues($(this).attr('olId'), 'ESDate', $(this).val());
    });

    // Add/Update Pcs Made
    $('#addPcsMadeBtn').click(function() {
        $.ajax({
            type: "GET",
            url: '/PLReport/addPcsMade',
            data: "pcsMadeId=" + $('#pcsMadeId').val() + "&pcsMadeDate=" + $('#pcsMadeDate').val() + "&pcsMadeQty=" + $('#pcsMadeQty').val() + "&orderlist_id=" + $('#orderlist_id').val() + "&pcsMadeQty_old=" + $('#pcsMadeQty_old').val(),
            success: function(msg) {
                var jason = $.parseJSON(msg);
                if (jason.status > 0) {
                    window.location.reload();
                } else {
                    alert(jason.msg);
                }
            }
        });

        return false;
    });

    // Cancel update on edit Pcs Made
    $('#cancelUpdate').click(function() {
        resetPcsMadeData();
    });

});

// Change datatable value as param fields
function changePlValues(olId, fieldName, fieldValue) {
    $.ajax({
        type: "GET",
        url: '/PLReport/changePlValues',
        data: "olId=" + olId + "&fieldName=" + fieldName + "&fieldValue=" + fieldValue,
        success: function(msg) {
            var jason = $.parseJSON(msg);
            if (!jason.status) {
                alert('Somthing went to wrong. Try again!!!');
            }
        }
    });
}

// Get pcs made details for popup
function getpcsDetails(orderListId, po_number, sku, amount)
{
    $('#myModal #orderlist_id').val(orderListId);
    resetPcsMadeData();

    $.ajax({
        type: "GET",
        url: '/PLReport/getPcsMadeDetails',
        data: "orderListId=" + orderListId,
        success: function(msg) {
            var jason = $.parseJSON(msg);
            var pcsStr = '';
            var totalQty = 0;
            $.each(jason, function(idx, data) {
                totalQty += Number(data.qty);
                actionStr = '<button class="btn btn-primary btn-sm" onclick="editPcs(this,' + data.id + ')" type="button"><i class="fa fa-pencil"></i></button><button class="btn btn-danger btn-sm"  onclick="deletePcs(' + data.id + ')" type="button"><i class="fa fa-trash-o"></i></button>';
                pcsStr += "<tr class='oldPcs'><td>" + po_number + "</td>" +
                        "<td class='pcsMadeDate'>" + data.date + "</td>" +
                        "<td>" + sku + "</td>" +
                        "<td class='pcsMadeQty'>" + data.qty + "</td>" +
                        "<td>" + amount + "</td>" +
                        "<td>" + actionStr + "</td></tr>";
            });
            if (pcsStr == '') {
                $('#pcsMadeTable').hide();
            } else {
                $('#pcsMadeTable').show();
                $('#pcsBody').html(pcsStr);
            }
        }
    });

    return false;
}

// Reset PcsMade form
function resetPcsMadeData() {
    $('#pcsMadeId').val('0');
    $('#pcsMadeDate').val('');
    $('#pcsMadeQty,#pcsMadeQty_old').val('');

    $('#addPcsMadeBtn').html('<i class="fa fa-plus"></i> Add');
    $('#cancelUpdate').hide();
}

// Edit Pcs set value to it's fields
function editPcs(element, pcsMadeId)
{
    trEle = $(element).closest('tr.oldPcs');

    $('#pcsMadeId').val(pcsMadeId);
    $('#pcsMadeDate').val($(trEle).find('.pcsMadeDate').html());
    $('#pcsMadeQty,#pcsMadeQty_old').val($(trEle).find('.pcsMadeQty').html());

    $('#addPcsMadeBtn').html('<i class="fa fa-edit"></i> Update');
    $('#cancelUpdate').show();

    return false;
}

// Delete Pcs Made by PcsMadeId
function deletePcs(pcsMadeId) {
    if (confirm('Are you sure want to delete?')) {
        $.ajax({
            type: "GET",
            url: '/PLReport/deletePcsMade',
            data: "pcsMadeId=" + pcsMadeId,
            success: function(msg) {
                var jason = $.parseJSON(msg);
                if (jason.status) {
                    window.location.reload();
                } else {
                    alert('Somthing went to wrong. Try again!!!');
                }
            }
        });
    }

    return false;
}