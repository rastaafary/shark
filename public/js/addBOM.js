$(document).ready(function () {
    id = $('#part_id').val();
    $.ajax({
        type: 'GET',
        url: baseURL+'/part/getskudescription',
        data: 'skuId=' + id,
        async: false,
        success: function (responce)
        {
            var jason = $.parseJSON(responce);
            $("#skuDescripton").val(jason.description);
        }
    });

});