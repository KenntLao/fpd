<!-- JS -->
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="/plugins/select2/js/select2.full.min.js"></script>
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/dist/js/adminlte.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>
<script src="/assets/js/common.js"></script>
<script src="/plugins/jquery-cookie/jquery.cookie.js"></script>
<script>
	var loader = $('#loader');
    var char_num = 50;
	$(function() {

        // clear notification number
        $('body').on('click', '#notif-clear', function (e) {
            $.post('/clear-notifications', {}, function (data) {}).done(function(){
            });
        });

        // hide loading after loading page
        // hideLoading();

        // javascript system language
        var sys_language = <?php echo $_SESSION['sys_language']; ?>;
		
		// set toast plugin
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000
		});
		
		// minimal select2 for forms
		$('.select2').select2();


		<?php
		// users for language change notification
		if(isset($_SESSION['sys_alert_toast_success'])) {
			?>
			Toast.fire({
				type: 'success',
				title: '<?php echo $_SESSION['sys_alert_toast_success']; ?>'
			});
			<?php
			unset($_SESSION['sys_alert_toast_success']);
		}
        ?>

        <?php 
        // reminders notification
        if(isset($_SESSION['sys_reminder_code'])) {
            foreach($_SESSION['sys_reminder_code'] as $key => $reminders) {
                ?>
                // $(document).Toasts('create', {
                //     class: 'toast-reminder', 
                //     title: 'Reminder',
                //     subtitle: "<?php echo $key; ?>",
                //     body: '<ul class="p-0"><?php 
                //         foreach($reminders as $reminder) {
                //            echo '<li class="reminder-list">'.str_replace("'", "\'", $reminder['reminder_message']).'<span class="float-right">'.formatDate($reminder['reminder_date']).'</span></li>';
                //             unset($_SESSION['sys_reminders'][$reminder['code']]);
                //         }
                //     ?></ul>'
                // });
                <?php 
            }
        }
        ?>

        // dismiss reminder
        $('body .toast').on('click', '.close', function(e) {
            var key = $(this).parent().find('small').html();
            $.post("/clear-reminders", {key:key}, function(data){});
        });

        // set number of notifications
        $('#notif-count').html('<?php echo $notif_count; ?>');
		$('#notif-count-msg').html('<?php echo $notif_count.' '.renderLang($notifications); ?>');


        // set currency format
        $('body').on('change, keydown, keyup, blur', "input[data-type='currency']", function(){
            formatCurrency($(this), "blur");
        });
        $("input[data-type='currency']").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() { 
            formatCurrency($(this), "blur");
            }
        });

		// update notification status on click
		$('body').on('click', '.notif-stat', function(e){

			var notif_id = $(this).data('id');
			$.post('/update-notif-status', {
				notif_id:notif_id
			}, function(data){
			});

		});

        // auto log out in 5min on stabdby
        $('body').on('mousemove', function(){

            $.cookie("hrs", 0, { expires: 1 , path: '/' });
            $.cookie("mns", 0, { expires: 1 , path: '/' });
            $.cookie("sec", 0, { expires: 1 , path: '/' });

        });

        // start timer
        timer();

	});

    // show loading before loading page
    // showLoading();

    // collapse sidebar on load
    $('body').removeClass('sidebar-open').addClass('sidebar-collapse');
	
    function showLoading() {
        $('.overlay, .loading').fadeIn(250);
    }
    function hideLoading() {
        $('.overlay, .loading').fadeOut(250);
    }

	// convert to currency to integer
	function convertCurrency(currency) {
		if (currency == 0 || currency == '') {
			return 0;
		} else {
			return currency.toString().replace(/,/g, "").replace(/₱/g, "").replace(/P/g, "").replace(" ", "") * 1;
		}

    }

    // timer
    function add() {

        var seconds = $.cookie('sec'),
        minutes = $.cookie('mns'),
        hours = $.cookie('hrs');

        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
            if (minutes >= 60) {
                minutes = 0;
                hours++;
            }
        }
        var hrs = hours;
        var mns = minutes;
        var sec = seconds;
        
        // var cur_time =  (hours > 0 ? (hours > 9 ? hours : "0"+hours) : "00") + ":" + (minutes > 0 ? (minutes > 9 ? minutes : "0"+minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);

        $.cookie("hrs", hrs, { expires: 1 , path: '/' });
        $.cookie("mns", mns, { expires: 1 , path: '/' });
        $.cookie("sec", sec, { expires: 1 , path: '/' });
        $.cookie("started", 1, { expires: 1 , path: '/' });

        if(minutes >= 30) {

            $.cookie("hrs", 0, { expires: 1 , path: '/' });
            $.cookie("mns", 0, { expires: 1 , path: '/' });
            $.cookie("sec", 0, { expires: 1 , path: '/' });
            window.location.href = '/logout';
        }

        timer();
    }

    // timer
    function timer() {
        timeout = setTimeout(add, 1000);
    }

</script>