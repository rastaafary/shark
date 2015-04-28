$(document).ready(function () {
    $('.skuDropDown').select2();
    $("#BOM_list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/getBomList/" + part_id + "/" + route_name,
        "aaSorting": [[7, "desc"]],
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [6]},
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
    });

    var orderNo = 1;
    $(oldBomData).each(function (key, val) {
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

    $("#addMoreOrder").click(function (e) {
        if ($('#scrap_rate').val() == 0 || $('#scrap_rate').val() == '' || parseInt($('#scrap_rate').val()) < 1) {
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

    });

    $('#cancelUpdate').click(function () {
        resetInputOrderData();
    });


    $('#part_id').change(function () {
        id = $('#part_id').val();
        $.ajax({
            type: 'GET',
            url: '/part/getskudescription',
            data: 'skuId=' + id,
            async: false,
            success: function (responce)
            {
                var jason = $.parseJSON(responce);
                $("#skuDescripton").val(jason.description);
            }
        });
    });
    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('partnumber'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/part/bom/searchRawMaterial',
        remote: '/part/bom/searchRawMaterial/%QUERY'
    });

    bestPictures.initialize();

    $('#selectedRawMaterial.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'partnumber',
        source: bestPictures.ttAdapter()
    }).on('typeahead:selected', function ($e, datum) {
        $('input[name="raw_material"]').val(datum["id"]);
    })

    $('#selectedRawMaterial').blur(function () {
        id = $('#raw_material').val();
        $.ajax({
            type: 'GET',
            url: '/part/bom/rawMaterialDescription',
            data: 'rawMaterialId=' + id,
            async: false,
            success: function (responce)
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

    $("#yield").blur(function () {
        // (Yield + Scrap Rate) * Bom Cost = total
        mul = (parseFloat($("#scrap_rate").val()) + parseFloat($("#yield").val())) * parseFloat($("#bom_cost").val());
        $("#total").val(mul.toFixed(2));
    });

    $('.two-digits').keyup(function () {
        if ($(this).val().indexOf('.') != -1) {
            if ($(this).val().split(".")[1].length > 2) {
                if (isNaN(parseFloat(this.value)))
                    return;
                this.value = parseFloat(this.value).toFixed(2);
            }
        }
        return this; //for chaining
    });


    $('.two-digits1').keyup(function () {
        if ($(this).val().indexOf('.') != -1) {
            if ($(this).val().split(".")[1].length > 2) {
                if (isNaN(parseFloat(this.value)))
                    return;
                this.value = parseFloat(this.value).toFixed(2);
            }
        }
        return this; //for chaining
    });

    $('#BOM').validate({
        submitHandler: function (form) {
            orders = [];
            $('tr.newOrderData').each(function () {
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
            if (orders.length > 0) {
                $('#deleteOrder').val(deleteOrder);
                $('#allOrderData').val(JSON.stringify(orders));
                form.submit();
            } else {
                $('#allOrderData').val('');
                alert('Please select Order');
                return false;
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
    if (confirm("Are You Sure You Want To Delete This Record ?")) {
        deleteOrder.push($(element).closest('tr.newOrderData').find('.orderId').val());
        $(element).closest('tr.newOrderData').remove();
    } else {
        return false;
    }
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
        url: '/po/add/order',
        data: {'customer_id': cust_id, 'searchSKU': searchSKU, 'searchQty': qty, 'amount': amount},
        async: false,
        headers: {
            'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (responce)
        {
        }
    });
}

