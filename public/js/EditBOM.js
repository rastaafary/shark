$(document).ready(function () {
    var raw_material = $("#raw_material").val();
    $.ajax({
        type: 'GET',
        url: '/part/bom/rawMaterialDescription',
        data: 'rawMaterialId=' + raw_material,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            rawMaterial = jason.partnumber.substring(0, 3) + "-";
            rawMaterial += jason.partnumber.substring(3, 6) + "-";
            rawMaterial += jason.partnumber.substring(6, 10);

            $("#selectedRawMaterial").val(rawMaterial);
            $("#descritpion").val(jason.description);
            $("#bom_cost").val(jason.bomcost);
            $("#unit").val(jason.unit);
        }
    });
    var skuid = $('#part_id').val();

    $.ajax({
        type: 'GET',
        url: '/part/getskudescription',
        data: 'skuId=' + skuid,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            $("#skuDescripton").val(jason.description);
        }
    });
});