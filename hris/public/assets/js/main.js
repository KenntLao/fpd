$(document).ready(function() {
	
	$('.select2').select2();
	$('.select-role').select2({
		placeholder: "Select Roles",
	});
	$('.workshift_time, .overtime_time').daterangepicker({
		timePicker: true,
		singleDatePicker: true,
		timePicker24Hour: true,
		timePickerIncrement: 1,
		locale: {
			format: 'HH:mm'
		}
		}).on('show.daterangepicker', function (ev, picker) {
			picker.container.find(".calendar-table").hide();
	});

	$('.work_sched').daterangepicker({
	    autoUpdateInput: false,
	    singleDatePicker: true,
	    showDropdowns: true,
	    minYear: 2020,
	    locale: {
	        format: 'Y-MM-d'
	    }
	}).on('apply.daterangepicker', function (ev, picker) {
	    $(this).val(picker.startDate.format('Y-MM-DD'));
	    var parent = $(this).parents('.form-group').parent();
	    if (parent) {
	        parent.find('.badge').addClass('badge-success').removeClass('badge-danger');
	    }
	}).on('cancel.daterangepicker', function (ev, picker) {
	    $(this).val('');
	    var parent = $(this).parents('.form-group').parent();
	    if (parent) {
	        parent.find('.badge').addClass('badge-danger').removeClass('badge-success');
	    }
	});

	$('.overtime_date, .ts_date').daterangepicker({
		autoUpdateInput: false,
	    singleDatePicker: true,
	    showDropdowns: true,
		minYear: 2020,
		locale: {
		    format: 'M-DD-Y'
		}
	}).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('M-DD-Y'));
		var parent = $(this).parents('.form-group').parent();
		if ( parent ) {
			parent.find('.badge').addClass('badge-success').removeClass('badge-danger');
		}
 	}).on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
		var parent = $(this).parents('.form-group').parent();
		if ( parent ) {
			parent.find('.badge').addClass('badge-danger').removeClass('badge-success');
		}
	 });
	 
	$('.travel_date, .ts_datetime').daterangepicker({
		autoUpdateInput: false,
	    singleDatePicker: true,
    	timePicker: true,
	    locale: {
	      	format: 'MM-DD-Y hh:mm A'
	    }
	}).on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM-DD-Y hh:mm A'));
		var parent = $(this).parents('.form-group').parent();
		if ( parent ) {
			parent.find('.badge').addClass('badge-success').removeClass('badge-danger');
		}
 	}).on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
		var parent = $(this).parents('.form-group').parent();
		if ( parent ) {
			parent.find('.badge').addClass('badge-danger').removeClass('badge-success');
		}
 	});

	$('.shift_time').hide()

	$('.workshift_check[checked]').each(function () {
		if ($(this).is(":checked")) {
			$(this).closest('.form-group').find('.shift_time').show();
		}
	});
	$(".workshift_check").click(function () {
		if ($(this).is(":checked")) {
			$(this).closest('.form-group').find('.shift_time').show();
		} else {
			$(this).closest('.form-group').find('.shift_time').hide();
		}
	});



	// validate required with minimum length
    $('input.required, select.required, textarea.required').on('keyup change', function () {
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
		if (obj.val() != null && obj.val().length >= minlength) {
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
	// CHANGE BADGE WHEN CHECKED
	$("input[type=checkbox]").change(function(){
		var parent = $(this).parents('.form-group').parent();
		if ($(this).prop('checked')) {
			parent.find('.badge').addClass('badge-success').removeClass('badge-danger');
        }
        else {
			parent.find('.badge').addClass('badge-danger').removeClass('badge-success');
        }
	});


	// DEPARTMENT == SUPERVISOR EMPLOYEE MODULE

	

});