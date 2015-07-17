var new_order = 0;

$(document).ready(function() {
    if (route_name == 'bom')
    {
        $.ajax({
            type: 'GET',
            url: baseURL + '/part/getskudescription',
            data: 'skuId=' + part_id,
            async: false,
            success: function(responce)
            {
                var jason = $.parseJSON(responce);
                $("#skuName").html(jason.SKU);
            }
        });
    }
    $('#part_id').change();
    $('.skuDropDown').select2();

    $("#BOM_list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": baseURL + "/getBomList/" + part_id + "/" + route_name,
        "aaSorting": [[7, "desc"]],
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [6]},
        ],
        "fnServerData": function(sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
        "fnInitComplete": function(oSettings, json) {
            total = 0;
            $.each(oSettings.aoData, function(key, val) {
                total = (parseFloat(total) + parseFloat(val._aData[5])).toFixed(4);
            });
            $('#BOMtotals').html(total);
        }
    });

    var orderNo = 1;
    $(oldBomData).each(function(key, val) {
        var order = [
            {
                orderNo: orderNo++,
                orderId: val.id,
                selectedRawMaterial: val.partnumber,
                raw_material: val.rowId,
                descritpion: val.description,
                bom_cost: val.bomcost,
                scrap_rate: val.scrap_rate,
                yield: val.yield,
                total: val.total,
                unit: val.name,
            }
        ];
        // Render the Order details
        $("#new-order-template").tmpl(order).appendTo("#purchaseOrderTbl tbody");
    });

    $("#scrap_rate, #yield").keydown(function(event) {
        if (!(event.keyCode == 8                                // backspace
                || event.keyCode == 9                               // tab
                || event.keyCode == 17                              // ctrl
                || event.keyCode == 46                              // delete
                || event.keyCode == 110                              // Dot
                || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
                || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
                || (event.keyCode >= 96 && event.keyCode <= 105)    // number on keypad
                || (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id))          // ctrl + a, on same control
                ) {
            event.preventDefault();     // Prevent character input
        }
        else {
            prevKey = event.keyCode;
            prevControl = event.currentTarget.id;
        }
    });


    $("#addMoreOrder").click(function(e) {
        if ($('#raw_material').val() == '') {
            alert('Please select valid Raw Material.');
            return false;
        }
        //if ($('#scrap_rate').val() == 0 || $('#scrap_rate').val() == '' || parseInt($('#scrap_rate').val()) < 1) {
        //var scrap_ratedata =$('#scrap_rate').val();
        if (parseInt($('#scrap_rate').val()) < 0) {
            alert('Please enter valid Scrape Rate.');
            return false;
        }
        if ($('#yield').val() == 0 || $('#yield').val() == '' || parseInt($('#yield').val()) < 1) {
            alert('Please enter valid Yield.');
            return false;
        }

        if ($('#updateId').val() !== '0') {
            template = $('#' + $('#updateId').val()).tmplItem();
            template.data.selectedRawMaterial = $('#selectedRawMaterial').val();
            template.data.raw_material = $('#raw_material').val();
            template.data.descritpion = $('#descritpion').val();
            template.data.bom_cost = $('#bom_cost').val();
            template.data.scrap_rate = $('#scrap_rate').val();
            template.data.yield = $('#yield').val();
            template.data.total = $('#total').val();
            template.data.unit = $('#unit').val();
            template.update();
        } else {
            new_order += 1;
            var order = [
                {
                    orderNo: orderNo++,
                    orderId: 0,
                    selectedRawMaterial: $('#selectedRawMaterial').val(),
                    raw_material: $('#raw_material').val(),
                    descritpion: $('#descritpion').val(),
                    bom_cost: $('#bom_cost').val(),
                    scrap_rate: $('#scrap_rate').val(),
                    yield: $('#yield').val(),
                    total: $('#total').val(),
                    unit: $('#unit').val(),
                }
            ];
            // Render the Order details
            $("#new-order-template").tmpl(order).appendTo("#purchaseOrderTbl tbody");
        }
        resetInputOrderData();

        //reset total Data
        resetTotalOrderData();
    });

    $('#cancelUpdate').click(function() {
        resetInputOrderData();
    });


    $('#part_id').change(function() {
        id = $('#part_id').val();
        $.ajax({
            type: 'GET',
            url: baseURL + '/part/getskudescription',
            data: 'skuId=' + id,
            async: false,
            success: function(responce)
            {
                var jason = $.parseJSON(responce);
                $("#skuDescripton").val(jason.description);
            }
        });
        var a = baseURL + "/part/" + id + "/bom/add";
        $(location).attr('href', a);
    });
    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('partnumber'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: baseURL + '/part/bom/searchRawMaterial',
        remote: baseURL + '/part/bom/searchRawMaterial/%QUERY'
    });

    bestPictures.initialize();

    $('#selectedRawMaterial.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'partnumber',
        source: bestPictures.ttAdapter()
    }).on('typeahead:selected', function($e, datum) {
        $('input[name="raw_material"]').val(datum["id"]);
    })

    $('#selectedRawMaterial').blur(function() {
        id = $('#raw_material').val();
        $.ajax({
            type: 'GET',
            url: baseURL + '/part/bom/rawMaterialDescription',
            data: 'rawMaterialId=' + id,
            async: false,
            success: function(responce)
            {
                var jason = $.parseJSON(responce);
                $("#raw_material").val(jason.id);
                $("#descritpion").val(jason.description);
                $("#bom_cost").val(jason.bomcost);
                $("#unit").val(jason.unit);
            }
        });
        //  $("#selectedRawMaterial").mask("aaa-aaa-9999");
    });

    $("#yield").blur(function() {
        // (Yield + Scrap Rate) * Bom Cost = total
//        var a = ((parseFloat($("#bom_cost").val()) * parseFloat($("#scrap_rate").val()))/100) / parseFloat($("#bom_cost").val());
//        var b = parseFloat($("#yield").val()) * parseFloat($(a).val());
//        var c = parseFloat($("#yield").val()) + parseFloat($(b).val());
//        mul = parseFloat($("#bom_cost").val()) + parseFloat($(c).val());
        mul = (((((parseFloat($("#bom_cost").val()) * parseFloat($("#scrap_rate").val())) / 100) / parseFloat($("#bom_cost").val())) * parseFloat($("#yield").val())) + parseFloat($("#yield").val())) * parseFloat($("#bom_cost").val());
        //mul = (parseFloat($("#scrap_rate").val()) + parseFloat($("#yield").val())) * parseFloat($("#bom_cost").val());
        $("#total").val(mul.toFixed(4));
    });

    $('.two-digits').keyup(function() {
        if ($(this).val().indexOf('.') != -1) {
            if ($(this).val().split(".")[1].length > 2) {
                if (isNaN(parseFloat(this.value)))
                    return;
                this.value = parseFloat(this.value).toFixed(4);
            }
        }
        return this; //for chaining
    });


    $('.two-digits1').keyup(function() {
        if ($(this).val().indexOf('.') != -1) {
            if ($(this).val().split(".")[1].length > 2) {
                if (isNaN(parseFloat(this.value)))
                    return;
                this.value = parseFloat(this.value).toFixed(4);
            }
        }
        return this; //for chaining
    });
    $('#scrap_rate').keyup(function() {

        if ($(this).val().indexOf('.') != -1) {

            if ($(this).val().split(".")[1].length > 4) {

                if (isNaN(parseFloat(this.value)))
                    return;
                this.value = parseFloat(this.value).toFixed(4);

            }
            if ($(this).val().split(".")[0].length > 2 ) {
                if (isNaN(parseFloat(this.value)))
                    return;
                //this.value = parseInt(this.value).toFixed(2);
                var intvalue = parseFloat($(this).val().split(".")[0].substr(0,2));
                this.value = parseFloat(intvalue+'.'+$(this).val().split(".")[1]);
            }
        } else if (parseInt($(this).val()) && $(this).val().length > 1 && $(this).val().indexOf('.') === -1) {
            if (isNaN(parseFloat(this.value)))
                return;
            this.value = parseFloat(this.value).toFixed(2);
        }
        return this; //for chaining
    });

    $('#BOM').validate({
        submitHandler: function(form) {
            orders = [];
            $('tr.newOrderData').each(function() {
                orders.push({
                    'orderId': $(this).find('.orderId').val(),
                    'selectedRawMaterial': $(this).find('.selectedRawMaterial').html(),
                    'raw_material': $(this).find('.raw_material').html(),
                    'descritpion': $(this).find('.descritpion').html(),
                    'scrap_rate': $(this).find('.scrap_rate').html(),
                    'yield': $(this).find('.yield').html(),
                    'total': $(this).find('.total').html()
                })
            });
            if (route_name == "add") {

                if (new_order > 0) {
                    $('#deleteOrder').val(deleteOrder);
                    $('#allOrderData').val(JSON.stringify(orders));
                    form.submit();
                } else {
                    $('#allOrderData').val('');
                    alert('Please Add Raw Material');
                    return false;
                }
            } else {
                $('#deleteOrder').val(deleteOrder);
                $('#allOrderData').val(JSON.stringify(orders));
                form.submit();
            }
        },
//        rules: {
//            'selectedRawMaterial': {
//                required: true,
//            },
//            'scrap_rate': {
//                required: true,
//                number: true
//            },
//            'yield': {
//                required: true,
//                number: true
//            },
//        },
//        messages: {
//            'selectedRawMaterial': {
//                required: 'Please enter Raw Material.'
//            },
//            'scrap_rate': {
//                required: 'Please enter Scrape rate.',
//                number: 'enter valid scrape rate *(number)'
//            },
//            'yield': {
//                required: 'Please enter yield.',
//                number: 'enter valid yield *(number)'
//
//            },
//        },
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


    //reset total Data
    resetTotalOrderData();

});

function editNewOrder(element)
{
    trEle = $(element).closest('tr.newOrderData');
    // $('#skuOrder').select2("val", $(trEle).find('.sku').attr('id'));
    $('#updateId').val($(trEle).attr('id'));
    $('#selectedRawMaterial').val($(trEle).find('.selectedRawMaterial').html());
    $('#raw_material').val($(trEle).find('.raw_material').html());
    $('#descritpion').val($(trEle).find('.descritpion').html());
    $('#bom_cost').val($(trEle).find('.bom_cost').html());
    $('#scrap_rate').val($(trEle).find('.scrap_rate').html());
    $('#yield').val($(trEle).find('.yield').html());
    $('#total').val($(trEle).find('.total').html());
    $('#unit').val($(trEle).find('.unit').html());
    $('#addMoreOrder').html('<i class="fa fa-edit"></i> Update');
    $('#cancelUpdate').show();
}



var deleteOrder = [];
function removeNewOrder(element)
{
    if (route_name == "add") {
        if (confirm("Are You Sure You Want To Delete This Record ?")) {
            deleteOrder.push($(element).closest('tr.newOrderData').find('.orderId').val());
            $(element).closest('tr.newOrderData').remove();
            if (new_order <= 0) {
                new_order = 0;
            }
            else {
                new_order = new_order - 1;
            }
        } else {
            return false;
        }
    }
    else {
        if (confirm("Are You Sure You Want To Delete This Record ?")) {
            deleteOrder.push($(element).closest('tr.newOrderData').find('.orderId').val());
            $(element).closest('tr.newOrderData').remove();
        } else {
            return false;
        }
    }

    //reset total Data
    resetTotalOrderData();
}

function resetInputOrderData() {
    $('#updateId').val('0');
    //$('#skuOrder').select2("val", '');
    $('#addMoreOrder').html('<i class="fa fa-plus"></i> Add');
    $('#cancelUpdate').hide();
    $('#selectedRawMaterial').val('');
    $('#descritpion').val('');
    $('#bom_cost').val('');
    $('#scrap_rate').val('');
    $('#yield').val('');
    $('#total').val('');
    $('#unit').val('');
}
function addOrder() {
    cust_id = $('#id').val();
    searchSKU = $('#searchSKU').val();
    searchQty = $('#searchQty').val();
    amount = $('#amount').val();
    $.ajax({
        type: 'POST',
        url: baseURL + '/po/add/order',
        data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
        async: false,
        headers: {
            'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(responce)
        {
        }
    });
}
function confirmDelete()
{
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        return true;
    } else {
        return false;
    }
}

//reset total Data
function resetTotalOrderData() {
    totalAmout = 0;
    $('tr.newOrderData').each(function() {
        totalAmout += parseFloat($(this).find('.total').html());
    });
    $('#totalAmout').html(totalAmout.toFixed(4));
}