$(function () {

    // validate required with minimum length
    $('input.required, select.required').on('keyup change', function () {
        checkRequired($(this));
        var minlength = 1;
        if ($(this).attr('minlength') != undefined) {
            minlength = $(this).attr('minlength');
        }
        if ($(this).val().length >= minlength) {
            $(this).closest('.form-group').find('.error-message').hide();
            $(this).closest('.form-group').find('label').removeClass('text-danger');
            $(this).closest('.form-group').find('label i').remove();
        }
    });
    $('input.required, select.required').each(function () {
        checkRequired($(this));
    });
    $('input').on('keyup change', function () {
        $(this).removeClass('is-valid').removeClass('is-invalid');
    });

    // modal confirm delete
    $('.btn-confirm-delete').click(function () {
        $('#modal_confirm_delete_upass').html('');
        $('.modal-error').html('').hide();
    });

    // run search
    $('#search-keywords').keyup(function (e) {
        if (e.which == 13) {
            $('#btn-search').click();
        }
    });
    $('#btn-search').click(function (e) {
        e.preventDefault();
        var keywords = $('#search-keywords').val();
        var currUrl = $(location).attr("href");
        var currUrl_arr = currUrl.split('?');
        var newUrl = '';
        if (typeof (getUrlParameter('p')) != 'undefined') {
            newUrl = currUrl_arr[0] + '?p=' + getUrlParameter('p');
        }
        if (keywords != '') {
            newUrl = currUrl_arr[0] + '?p=1&k=' + encodeURIComponent(keywords);
        } else {
            newUrl = currUrl_arr[0] + '?p=1';
        }
        if (typeof (getUrlParameter('dt')) != 'undefined') {
            newUrl += '&dt=' + getUrlParameter('dt');
        }
        window.location.href = newUrl;
    });

    // run search v2
    $('#search-filter').on('click', function (e) {
        e.preventDefault();
        var keywords = $('#search-keywords').val();
        var currUrl = $(location).attr("href");
        var currUrl_arr = currUrl.split('?');
        var newUrl = '';
        if (typeof (getUrlParameter('page')) != 'undefined') {
            newUrl = currUrl_arr[0] + '?page=' + getUrlParameter('page');
        }
        if (keywords != '') {
            newUrl = currUrl_arr[0] + '?page=1&k=' + encodeURIComponent(keywords);
        } else {
            newUrl = currUrl_arr[0] + '?page=1';
        }
        if (typeof (getUrlParameter('dt')) != 'undefined') {
            newUrl += '&dt=' + getUrlParameter('dt');
        }
        window.location.href = newUrl;

    });
    $('#search-keywords').keypress(function (e) {
        if (e.keyCode == '13') { // enter key
            $('#search-filter').click();
        }
    });

});

function checkRequired(obj) {
    var minlength = 1;
    if (obj.attr('minlength') != undefined) {
        minlength = obj.attr('minlength');
    }
    if (obj.val().length >= minlength) {
        obj.closest('.form-group').find('.badge').addClass('badge-success').removeClass('badge-danger');
    } else {
        obj.closest('.form-group').find('.badge').addClass('badge-danger').removeClass('badge-success');
    }
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

// check file extensions
$(function () {

    $('body').on('change', 'input[type="file"]', function (e) {

        $this = $(this);

        var attachment_num = e.target.files.length;
        if (attachment_num > 0) {

            var file_names = [];

            for (var i = 0; i < attachment_num; i++) {
                file_names.push(e.target.files[i].name);
            }

            $.post('/verify-attachment-extension', {
                file_names: file_names
            }, function (data) {
                if (data != 'valid') {
                    $this.val('');
                    $('#modal-import').modal('hide');
                    $('#modal-attachment-alert').modal('show');
                }
            });
        }

    });

});

function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}

// auto forat currency
function formatCurrency(input, blur) {

    // currency symbol
    var currency_symbol = '₱'; // ₱

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position 
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = currency_symbol + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = currency_symbol + input_val;

        // final formatting
        if (blur === "blur") {
            input_val += ".00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

// format number to currency
function convert_to_currency(value, blur) {

    // currency symbol
    var currency_symbol = '₱'; // ₱

    // don't validate empty input
    if (value === "") {
        return;
    }

    value = value.toString();

    if (value.includes(".")) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = value.lastIndexOf(".");

        // split number by decimal point
        var left_side = value.substring(0, decimal_pos);
        var right_side = value.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        value = currency_symbol + left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        value = formatNumber(value);
        value = currency_symbol + value;

        // final formatting
        if (blur === "blur") {
            value += ".00";
        }
    }

    return value;

}

// Custom in array function
function inArray(needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (haystack[i] == needle) return true;
    }
    return false;
}