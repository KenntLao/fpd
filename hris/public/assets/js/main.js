$(document).ready(function() {
	$('.select2').select2();
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
    $('input.required, select.required, textarea.required').each(function () {
        checkRequired($(this));
    });
    $('input').on('keyup change', function () {
        $(this).removeClass('is-valid').removeClass('is-invalid');
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
	$('input, textarea').each(function() {
		if($(this).val()) {
			$(this).addClass("active").siblings(".placeholder").addClass("active");
		}
	});
	$("input, textarea").on("focus", function () {
		$(this).addClass("active").siblings(".placeholder").addClass("active");
	});
	$("input, textarea").on("blur", function () {
	
		if (jQuery.trim($(this).val() ) == '' ) {
			$(this).removeClass("active").siblings(".placeholder.active").removeClass("active");
		};
	
	});

	function stateCheck($formControl) {
		if($formControl.val().length > 0) {
			$formControl.addClass('valid');
		} else {
			$formControl.removeClass('valid');
		}
	}

	$('.form-control').on('focusout', function(){
		stateCheck($(this));
	});

});