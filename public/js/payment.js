$(document).ready(function() {
    var bestPictures = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('contact_name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: '/payment/searchCustomer',
        remote: '/payment/searchCustomer/%QUERY'
    });

    bestPictures.initialize();

    $('#searchCustomer.typeahead').typeahead(null, {
        name: 'best-pictures',
        displayKey: 'contact_name',
        source: bestPictures.ttAdapter()
    }).on('typeahead:selected', function($e, datum) {
        $('input[name="selectedCust"]').val(datum["id"]);
    });


    // Get invoice list from customer
    $(".tt-dropdown-menu").click(function() {
        custId = $('input[name="selectedCust"]').val();
        $.ajax({
            type: 'GET',
            url: '/payment/getCustInvoice',
            data: 'custId=' + custId,
            async: false,
            success: function(responce) {
                var jason = $.parseJSON(responce);
                var str = '<option value="0" selected disabled>Select Invoice</option>';
                $.each(jason, function(idx, data) {
                    str += "<option value=" + data.id + ">" + data.invoice_no + "</option>";
                });
                $("#invoiceSelect").html(str);
            }
        });
    });

    // Get invoice history on Invoice change
    $("#invoiceSelect").change(function() {
        $('#invoiceListBlock,#invoiceDetailBlock').hide();
        $.ajax({
            type: 'GET',
            url: '/payment/getInvoicePaymentDetails',
            data: 'invoiceId=' + $(this).val(),
            async: false,
            success: function(responce) {
                $('#invoiceListBlock,#invoiceDetailBlock').show();
                var jason = $.parseJSON(responce);
                var totalPaid = 0;

                // For invoice details
                var invoiceDetailsStr = '';
                $.each(jason.invoiceDetails, function(idx, data) {
                    totalPaid += Number(data.paid);
                    invoiceDetailsStr += "<tr><td>" + data.date + "</td><td>$" + data.paid + "</td><td>" + data.payment_ref_no + "</td><td>" + data.comments + "</td></tr>";
                });
                if (invoiceDetailsStr == '') {
                    invoiceDetailsStr = '<span>Payment details not available.</span>';
                }
                $('#invoiceDetailDT').html(invoiceDetailsStr);

                // For invoice list
                var invoiceStr = '';
                $.each(jason.invoice, function(idx, data) {
                    if (data.total == '' || data.total == null)
                        data.total = 0;
                    invoiceStr += "<tr><td>" + data.invoice_no + "</td><td>$" + data.total + "</td><td>$" + totalPaid + "</td><td>$" + (data.total - totalPaid) + "</td></tr>";
                });
                if (invoiceStr == '') {
                    invoiceStr = '<span>Invoice not available.</span>';
                }
                $('#invoiceListDT').html(invoiceStr);
            }
        });
    });

    $('#require_date,#paymentDate,#p_date').datepicker({format: "yyyy-mm-dd", todayBtn: true, todayHighlight: true}).on('changeDate', function (ev) {
        $(this).datepicker('hide');
        $(document.activeElement).trigger("blur");
    });

    $("#payment-list").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "/payment/getPaymentList",
        "aaSorting": [[0, "asc"]],
        "aoColumnDefs": [
            {"bSearchable": false, "aTargets": [4]},
            {"bSortable": false, "aTargets": [4]},
        ],
        "fnServerData": function(sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "GET",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        }
    });

    // Delete payment
    $('.deletePayment').click(function() {
        if (!confirm('Are you sure want to delete?')) {
            return false;
        }
    });

    // Cancel update on edit payment
    $('#cancelUpdate').click(function() {
        resetPaymentData();
    });

    // Custome validation for amount
    jQuery.validator.addMethod("amount", function(value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "Please enter valid amount.");

    // Payment form validate
    $('form[name="paymentForm"]').validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            'paymentDate': {
                required: true
            },
            'searchCustomer': {
                required: true
            },
            'invoiceSelect': {
                required: true
            },
            'txtAmount': {
                required: true,
                amount: true
            },
            'paymentRefNo': {
                maxlength: 20
            },
            'comments': {
                maxlength: 250
            }
        },
        messages: {
            'paymentDate': {
                required: 'Please select date.'
            },
            'searchCustomer': {
                required: 'Please select customer.'
            },
            'invoiceSelect': {
                required: 'Please select invoice.'
            },
            'txtAmount': {
                required: 'Please enter amount.'
            },
            'paymentRefNo': {
                maxlength: 'Reference number must not exceed limit of 20 characters.'
            },
            'comments': {
                maxlength: 'Comments must not exceed limit of 250 characters.'
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-info');
        },
        errorElement: 'label',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Quick Payment form validate
    $('form[name="quickPaymentForm"]').validate({
        submitHandler: function(form) {
            form.submit();
        },
        rules: {
            'p_date': {
                required: true
            },
            'p_paid': {
                required: true,
                amount: true
            },
            'p_refno': {
                maxlength: 20
            },
            'p_comment': {
                maxlength: 250
            }
        },
        messages: {
            'p_date': {
                required: 'Please select date.'
            },
            'p_paid': {
                required: 'Please enter amount.'
            },
            'p_refno': {
                maxlength: 'Reference number must not exceed limit of 20 characters.'
            },
            'p_comment': {
                maxlength: 'Comments must not exceed limit of 250 characters.'
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-info');
        },
        errorElement: 'label',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});

// Edit payment set value to it's fields
function editPayment(element)
{
    trEle = $(element).closest('tr.oldPayment');

    $('#p_id').val($(trEle).find('.p_id').val());
    $('#p_date').val($(trEle).find('.p_date').html());
    $('#p_paid,#p_old_paid').val($(trEle).find('.p_paid').html());
    $('#p_refno').val($(trEle).find('.p_refno').html());
    $('#p_comment').val($(trEle).find('.p_comment').html());

    $('#addMorePayment').html('<i class="fa fa-edit"></i> Update');
    $('#cancelUpdate').show();

    return false;
}

// Reset quick payment form
function resetPaymentData() {
    $('#p_id').val('0');
    $('#p_date').val('');
    $('#p_paid,#p_old_paid').val('');
    $('#p_refno').val('');
    $('#p_comment').val('');

    $('#addMorePayment').html('<i class="fa fa-plus"></i> Add');
    $('#cancelUpdate').hide();
}