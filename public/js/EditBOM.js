$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: '/part/getskudescription',
        data: 'skuId=' + part_id,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            $("#skuDescripton").val(jason.description);
        }
    });
  /*  $.ajax({
        type: 'GET',
        url: '/part/bom/getBomData',
        data: 'partId=' + part_id,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
//            rawMaterial = jason.partnumber.substring(0, 3) + "-";
//            rawMaterial += jason.partnumber.substring(3, 6) + "-";
//            rawMaterial += jason.partnumber.substring(6, 10);

            $("#selectedRawMaterial").val(jason.partnumber);
            $("#raw_material").val(jason.id);
            $("#descritpion").val(jason.description);
            $("#bom_cost").val(jason.bomcost);
            $("#scrap_rate").val(jason.scrap_rate);
            $("#yield").val(jason.yield);
            $("#total").val(jason.bomcost);
            $("#unit").val(jason.name); 
        }
    });*/
});