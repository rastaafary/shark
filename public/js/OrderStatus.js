var oTable;
$(document).ready(function ()
{

    $('#pcsMadeDate').datepicker({format: "yyyy-mm-dd", todayBtn: true, todayHighlight: true}).on('changeDate', function (ev) {
        $(this).datepicker('hide');
        $(document.activeElement).trigger("blur");
    });


    $("#openCloseToggle").change(function () {
        if ($('#openCloseToggle').prop('checked') == true) {
            // 0 
            oTable.fnReloadAjax('/PLReport/orderlist/0');
        } else {
            oTable.fnReloadAjax('/PLReport/orderlist/1');

            //1 
        }
    });

    $('body').click(function (eve) {
        if (eve.target.id !== 'ESDate') {
            $('.ESDate').datepicker("hide");
            if ($('.ESDate').is(':focus')) {
                $(document.activeElement).trigger("blur");
            }
        } else {
            $('.ESDate').datepicker({format: "yyyy-mm-dd", todayBtn: true, todayHighlight: true}).on('changeDate', function (ev) {
                $(this).datepicker('hide');
                $(document.activeElement).trigger("blur");
            });
        }
    });

    // data table refresh & reload function code
    $.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, sNewSource, fnCallback)
    {
        if (typeof sNewSource != 'undefined') {
            oSettings.sAjaxSource = sNewSource;
        }
        this.oApi._fnProcessingDisplay(oSettings, true);
        var that = this;
        oSettings.fnServerData(oSettings.sAjaxSource, null, function (json) {
            /* Clear the old information from the table */
            that.oApi._fnClearTable(oSettings);
            /* Got the data - add it to the table */
            for (var i = 0; i < json.aaData.length; i++) {
                that.oApi._fnAddData(oSettings, json.aaData[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            that.fnDraw(that);
            that.oApi._fnProcessingDisplay(oSettings, false);
            /* Callback user function - for event handlers etc */
            if (typeof fnCallback == 'function') {
                fnCallback(oSettings);
            }
        });
    }
    //var sequence = 1;
    // Set datatable
    oTable = $("#order-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/PLReport/orderlist/0",
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [0]},
            {"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8]}
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
            $('.ESDate').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayBtn: true,
                todayHighlight: true
            });
            if($('#order-list_filter input').val() != '') {
                $('#order-list tbody').sortable("disable" );
            } else {
                $('#order-list tbody').sortable("enable" );
            }
        },
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //$(nRow).find('td:first').html(sequence++);
            $(nRow).attr('id', aData[9]);
            return nRow;
        }
    });
    
  
    
    
    $('#order-list tbody').sortable({
        stop: function () {
            $("#order-list_processing").css("visibility", "visible");
            var orderId = [];
            var sequence = [];
            $('#order-list tbody tr').each(function () {
                orderId.push($(this).attr('id'));
                sequence.push(parseInt($(this).find('td:first').html()));
            });
            $.ajax({
                type: "GET",
                url: "/PLReport/reOrderData",
                data: {orderId: orderId, max: Math.max.apply(Math, sequence), min: Math.min.apply(Math, sequence)},
                success: function (data) {
                    oTable.fnReloadAjax();
                }
            });
            $('.ESDate').datepicker("hide");
            return true;
        }
    });

    // Change status of PL's
    $('body').delegate('#order-list #plStatusChange', 'change', function () {
        changePlValues($(this).attr('olId'), 'pl_status', $(this).val());
    });

    // On shipping date change
    $('body').delegate('#order-list #ESDate', 'focusout', function () {
        changePlValues($(this).attr('olId'), 'ESDate', $(this).val());
    });

    //check order status
    $('body').delegate('.btnPcsMade', 'click', function () {
        if ($(this).closest('tr').find('#plStatusChange option:selected').val() == 1) {
            $('#addMorePcsMadePopup').hide();
        } else {
            $('#addMorePcsMadePopup').show();
        }
    });

    // Add/Update Pcs Made
    $('#addPcsMadeBtn').click(function () {
        $.ajax({
            type: "GET",
            url: '/PLReport/addPcsMade',
            data: "pcsMadeId=" + $('#pcsMadeId').val() + "&pcsMadeDate=" + $('#pcsMadeDate').val() + "&pcsMadeQty=" + $('#pcsMadeQty').val() + "&orderlist_id=" + $('#orderlist_id').val() + "&pcsMadeQty_old=" + $('#pcsMadeQty_old').val(),
            success: function (msg) {
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

    //Toggle change
//   $('#openCloseToggle')(function(){
//       alert($("#openCloseToggle").val());
//    });
//    
//    


    // Cancel update on edit Pcs Made
    $('#cancelUpdate').click(function () {
        resetPcsMadeData();
    });

});

// Change datatable value as param fields
function changePlValues(olId, fieldName, fieldValue) {
    $('.ESDate').datepicker("hide");
    $.ajax({
        type: "GET",
        url: '/PLReport/changePlValues',
        data: "olId=" + olId + "&fieldName=" + fieldName + "&fieldValue=" + fieldValue,
        success: function (msg) {
            oTable.fnReloadAjax();
//            var jason = $.parseJSON(msg);
//            if (!jason.status) {
//                alert('Somthing went to wrong. Try again!!!');
//            }
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
        success: function (msg) {
            var jason = $.parseJSON(msg);
            var pcsStr = '';
            var totalQty = 0;
            $.each(jason, function (idx, data) {
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
            success: function (msg) {
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