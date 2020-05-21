hr_total = 0;
var labor_cost = $('#labor-cost').val();
labor_cost = convertCurrency(labor_cost);
var labor_cost_outsource = $('#labor-cost-outsource').val();
labor_cost_outsource = convertCurrency(labor_cost_outsource);
$(function () {
    // HR total auto compute
    $('body').on('change, keyup', 'input[name="budget_base_pay[]"], input[name="budget_allowance[]"], input[name="head_count[]"], .plantilla', function () {

        var base_pay_total = 0;
        var allowance_total = 0;
        var head_count = 1;

        // base pay total
        $('input[name="budget_base_pay[]"]').each(function () {
            var val = $(this).val();

            head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
            if (head_count == '' || head_count == 0) {
                head_count = 1;
            }

            val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
            base_pay_total += val * head_count;
        });

        // allowance total
        $('input[name="budget_allowance[]"]').each(function () {
            var val = $(this).val();

            head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
            if (head_count == '' || head_count == 0) {
                head_count = 1;
            }

            val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
            allowance_total += val * head_count;
        });

        hr_total = base_pay_total + allowance_total;

        $('#hr_total').val(hr_total);
        formatCurrency($('#hr_total'), "blur");

        labor_cost = hr_total;

        // $('#labor-cost').val(hr_total);
        // formatCurrency($('#labor-cost'), "blur");
    });

    // calculate on load
    var base_pay_total = 0;
    var allowance_total = 0;
    var head_count = 1;

    // base pay total
    $('input[name="budget_base_pay[]"]').each(function () {
        var val = $(this).val();

        head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
        if (head_count == '' || head_count == 0) {
            head_count = 1;
        }

        val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
        base_pay_total += val * head_count;
    });

    // allowance total
    $('input[name="budget_allowance[]"]').each(function () {
        var val = $(this).val();

        head_count = $(this).closest('tr').find('input[name="head_count[]"]').val();
        if (head_count == '' || head_count == 0) {
            head_count = 1;
        }

        val = val.replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "");
        allowance_total += val * head_count;
    });

    hr_total = base_pay_total + allowance_total;

    $('#hr_total').val(hr_total);
    formatCurrency($('#hr_total'), "blur");

    labor_cost = hr_total;

    // $('#labor-cost').val(hr_total);
    // formatCurrency($('#labor-cost'), "blur");
    // 
});


$(function () {

    // auto compute CAD total
    var cad_total = 0;
    var dp_total = 0;
    var total_cost = 0;
    var vat = 1;
    var vat_total = 0;
    var total_cost_vat = 0;
    var downpayment_term = 1;

    downpayment_term = $('.downpayment-term').val() * 1;

    if ($('#vat').is(':checked')) {
        vat = 1.12;
    }

    labor_cost = $('#labor-cost').val();
    labor_cost = convertCurrency(labor_cost);
    labor_cost_outsource = $('#labor-cost-outsource').val();
    labor_cost_outsource = convertCurrency(labor_cost_outsource);

    labor_cost += labor_cost_outsource;

    $('.cad-amount').each(function () {
        var val = $(this).val();
        val = convertCurrency(val);
        cad_total += val * 1;
    });

    $('#CAD-total').val(cad_total);
    formatCurrency($('#CAD-total'), "blur");

    total_cost = cad_total + labor_cost;

    total_cost_vat = total_cost * vat;
    total_cost_vat = total_cost_vat.toFixed(2);
    $('#sub_total_cost').val(convert_to_currency(total_cost_vat, "blur"));

    total_cost_vat = Math.ceil(total_cost_vat / 1000) * 1000;

    vat_total = total_cost * 0.12;

    $('#vat-total').val(vat_total);
    formatCurrency($('#vat-total'), "blur");

    $('#total-cost').val(total_cost);
    formatCurrency($('#total-cost'), "blur");

    $('#total-cost-vat').val(total_cost_vat);
    formatCurrency($('#total-cost-vat'), "blur");

    dp_total = total_cost_vat * downpayment_term;
    $('#dp-amount').val(dp_total);
    formatCurrency($('#dp-amount'), "blur");

    $('body').on('change, keyup', '.cad-amount', function () {
        cad_total = 0;
        dp_total = 0;
        total_cost = 0;
        vat_total = 0;
        total_cost_vat = 0;

        downpayment_term = $('.downpayment-term').val() * 1;

        labor_cost = $('#labor-cost').val();
        labor_cost = convertCurrency(labor_cost);
        labor_cost_outsource = $('#labor-cost-outsource').val();
        labor_cost_outsource = convertCurrency(labor_cost_outsource);

        labor_cost += labor_cost_outsource;

        $('.cad-amount').each(function () {
            var val = $(this).val();
            val = convertCurrency(val);
            cad_total += val * 1;
        });

        if ($('#vat').is(':checked')) {
            vat = 1.12;
        } else {
            vat = 1;
        }

        $('#CAD-total').val(cad_total);
        formatCurrency($('#CAD-total'), "blur");

        total_cost = cad_total + labor_cost;

        total_cost = total_cost;

        vat_total = total_cost * 0.12;

        $('#vat-total').val(vat_total);
        formatCurrency($('#vat-total'), "blur");

        $('#total-cost').val(total_cost);
        formatCurrency($('#total-cost'), "blur");

        total_cost_vat = total_cost * vat;
        total_cost_vat = total_cost_vat.toFixed(2);
        $('#sub_total_cost').val(convert_to_currency(total_cost_vat, "blur"));

        total_cost_vat = Math.ceil(total_cost_vat / 1000) * 1000;

        $('#total-cost-vat').val(total_cost_vat);
        formatCurrency($('#total-cost-vat'), "blur");

        dp_total = total_cost_vat * downpayment_term;
        $('#dp-amount').val(dp_total);
        formatCurrency($('#dp-amount'), "blur");

    });

    $('#labor-cost, #labor-cost-outsource').on('keyup', function () {

        labor_cost = $('#labor-cost').val();
        labor_cost = convertCurrency(labor_cost);
        labor_cost_outsource = $('#labor-cost-outsource').val();
        labor_cost_outsource = convertCurrency(labor_cost_outsource);

        labor_cost += labor_cost_outsource;

        downpayment_term = $('.downpayment-term').val() * 1;

        cad_total = 0;
        dp_total = 0;
        total_cost = 0;

        if ($('#vat').is(':checked')) {
            vat = 1.12;
        } else {
            vat = 1;
        }


        $('.cad-amount').each(function () {
            var val = $(this).val();
            val = convertCurrency(val);
            cad_total += val * 1;
        });

        total_cost = cad_total + labor_cost;

        vat_total = total_cost * 0.12;

        $('#vat-total').val(vat_total);
        formatCurrency($('#vat-total'), "blur");

        $('#total-cost').val(total_cost);
        formatCurrency($('#total-cost'), "blur");

        total_cost_vat = total_cost * vat;
        total_cost_vat = total_cost_vat.toFixed(2);
        $('#sub_total_cost').val(convert_to_currency(total_cost_vat, "blur"));

        total_cost_vat = Math.ceil(total_cost_vat / 1000) * 1000;

        $('#total-cost-vat').val(total_cost_vat);
        formatCurrency($('#total-cost-vat'), "blur");

        dp_total = total_cost_vat * downpayment_term;
        $('#dp-amount').val(dp_total);
        formatCurrency($('#dp-amount'), "blur");

    });

    $('#vat').on('change', function () {

        cad_total = 0;
        dp_total = 0;
        total_cost = 0;
        total_cost_vat = 0;

        labor_cost = $('#labor-cost').val();
        labor_cost = convertCurrency(labor_cost);
        labor_cost_outsource = $('#labor-cost-outsource').val();
        labor_cost_outsource = convertCurrency(labor_cost_outsource);

        labor_cost += labor_cost_outsource;

        downpayment_term = $('.downpayment-term').val() * 1;

        if ($('#vat').is(':checked')) {
            vat = 1.12;
        } else {
            vat = 1;
        }


        $('.cad-amount').each(function () {
            var val = $(this).val();
            val = convertCurrency(val);
            cad_total += val * 1;
        });

        $('#CAD-total').val(cad_total);
        formatCurrency($('#CAD-total'), "blur");

        total_cost = cad_total + labor_cost;

        vat_total = total_cost * 0.12;

        $('#vat-total').val(vat_total);
        formatCurrency($('#vat-total'), "blur");

        total_cost_vat = total_cost * vat;
        total_cost_vat = total_cost_vat.toFixed(2);

        $('#sub_total_cost').val(convert_to_currency(total_cost_vat, "blur"));

        total_cost_vat = Math.ceil(total_cost_vat / 1000) * 1000;

        $('#total-cost-vat').val(total_cost_vat);
        formatCurrency($('#total-cost-vat'), "blur");

        dp_total = total_cost_vat * downpayment_term;
        $('#dp-amount').val(dp_total);
        formatCurrency($('#dp-amount'), "blur");

    });

    $('body').on('change', '.downpayment-term', function () {

        cad_total = 0;
        dp_total = 0;
        total_cost = 0;
        total_cost_vat = 0;

        downpayment_term = $('.downpayment-term').val() * 1;

        if ($('#vat').is(':checked')) {
            vat = 1.12;
        } else {
            vat = 1;
        }

        $('.cad-amount').each(function () {
            var val = $(this).val();
            val = convertCurrency(val);
            cad_total += val * 1;
        });

        $('#CAD-total').val(cad_total);
        formatCurrency($('#CAD-total'), "blur");

        total_cost = cad_total + labor_cost;

        vat_total = total_cost * 0.12;

        $('#vat-total').val(vat_total);
        formatCurrency($('#vat-total'), "blur");

        total_cost_vat = total_cost * vat;
        total_cost_vat = total_cost_vat.toFixed(2);

        total_cost_vat = Math.ceil(total_cost_vat / 1000) * 1000;

        $('#total-cost-vat').val(total_cost_vat);
        formatCurrency($('#total-cost-vat'), "blur");

        dp_total = total_cost_vat * downpayment_term;
        $('#dp-amount').val(dp_total);
        formatCurrency($('#dp-amount'), "blur");

    });

});