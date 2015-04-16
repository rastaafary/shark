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
                $("#selectedRawMaterial").val(jason.partnumber);
                $("#descritpion").val(jason.description);
                $("#bom_cost").val(jason.bomcost);
                $("#unit").val(jason.unit);
            }
        });
        $("#selectedRawMaterial").mask("aaa-aaa-9999");
    });

    $("#yield").blur(function () {
        mul = $(".two-digits").val() * $(".two-digits1").val();
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
        rules: {
            'selectedRawMaterial': {
                required: true,
            },
            'scrap_rate': {
                required: true,
                number: true
            },
            'yield': {
                required: true,
                number: true
            },
            'total': {
                required: true,
            },
            'skuDescripton' : {
                required: true
            }

        },
        messages: {
            'selectedRawMaterial': {
                required: 'Please enter Raw Material.'
            },
            'scrap_rate': {
                required: 'Please enter Scrape rate.',
                number: 'enter valid scrape rate *(number)'
            },
            'yield': {
                required: 'Please enter yield.',
                number: 'enter valid yield *(number)'

            },
            'total': {
                required: 'Please enter Total.'
            },
            'skuDescripton' : {
                required: 'Please enter SKU Description.'
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