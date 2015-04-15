$(document).ready(function () {
    $('.skuDropDown').select2();

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
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('description'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/part/bom/searchRawMaterial',
        remote: '/part/bom/searchRawMaterial/%QUERY'
    });

    bestPictures.initialize();

    $('#selectedRawMaterial.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'description',
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
                $("#unit").val(jason.stockunit);
            }
        });
    });

    $("#yield").blur(function () {
        $("#total").val($("#bom_cost").val() * $("#yield").val());
    });

});