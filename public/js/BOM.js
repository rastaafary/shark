$(document).ready(function () {
    $('.skuDropDown').select2();

    $("#BOM_list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/getBomList/" + part_id,
        "aaSorting": [[7, "desc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [3]},
            {"bSortable": false, "aTargets": [2, 3]}

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
                $("#descritpion").val(jason.description);
                $("#bom_cost").val(jason.bomcost);
                $("#unit").val(jason.unit);
            }
        });
        $("#selectedRawMaterial").mask("aaa-aaa-9999");
    });

    //edit BOM validation
        $("#yield").blur(function () {
        $("#total").val($("#bom_cost").val() * $("#yield").val());
    });

    $('#BOM').validate({
        rules: {
            'selectedRawMaterial': {
                required: true,
            },
            'scrap_rate': {
                required: true,
            },
            'yield': {
                required: true,
            },
            'total': {
                required: true,
            }

        },
        messages: {
            'selectedRawMaterial': {
                required: 'Please enter Raw Material.'
            },
            'scrap_rate': {
                required: 'Please enter Scrape rate.'
            },
            'yield': {
                required: 'Please enter yield.'

            },
            'total': {
                required: 'Please enter Total.'

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

    $('#BOM').validate({
        rules: {
            'selectedRawMaterial': {
                required: true,
            },
            'scrap_rate': {
                required: true,
            },
            'yield': {
                required: true,
            },
            'total': {
                required: true,
            }

        },
        messages: {
            'selectedRawMaterial': {
                required: 'Please enter Raw Material.'
            },
            'scrap_rate': {
                required: 'Please enter Scrape rate.'
            },
            'yield': {
                required: 'Please enter yield.'

            },
            'total': {
                required: 'Please enter Total.'

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