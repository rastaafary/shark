sequence = [];
$(document).ready(function () {
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
    oTable = $("#production-sequence").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseURL + "/sequence/get-list",
        "aaSorting": [[0, "desc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [0, 3]},
            {"bSortable": false, "aTargets": [0, 3]},
            {"bVisible": false, "aTargets": [0,3]}
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
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //$(nRow).find('td:first').html(sequence++);
            $(nRow).attr('id', aData[0]);
            return nRow;
        }
    });
    setTimeout(function () {
        $('#production-sequence tbody').sortable({            
            stop: function (event, ui) {
                $("#production-sequence_processing").css("visibility", "visible");
                var seqId = [];
                $('#production-sequence tbody tr').each(function () {
                    seqId.push($(this).attr('id'));
                });
                $.ajax({
                    type: "post",
                    url: baseURL + "/sequence/order",
                    data: {'seqId': seqId, '_token': $('input[name=_token]').val()},
                    success: function (data) {
                        oTable.fnReloadAjax();
                        sequence = seqId;
                        $("#production-sequence_processing").css("visibility", "hidden");
                    }
                });
                return true;
            }
        });
    }, 1000);
    //edit part validation
    $('#editpart').validate({
        // ignore: '.select2-input',

        rules: {
            'SKU': {
                required: true,
                alphaNum: true
            },
            'description': {
                required: true,
            },
//            'labels[]':{
//             required: true,
//            },
//
//            'label[]': {
//                required: true,
//            },
            'cost': {
                required: true,
                amountValidation: true,
            },
            'ai': {
                extension: "ai"
            }
        },
        messages: {
            'SKU': {
                required: 'Please enter SKU.'
            },
            'description': {
                required: 'Please enter description.'
            },
//            'labels[]': {
//                required: 'Please enter size.'
//            },
//            'label[]': {
//                required: 'Please enter components.'
//            },
            'cost': {
                required: 'Please enter cost.'

            },
            'ai': {
                extension: 'Please only upload ai file.'
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