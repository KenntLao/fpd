<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('calendar')) {

  $page = 'calendar';

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($calendar_calendar); ?> &middot; <?php echo $sitename; ?></title>

    <link rel="stylesheet" href="/plugins/calendar/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="/plugins/calendar/fullcalendar/fullcalendar.print.css" media="print">
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	
	<!-- WRAPPER -->
	<div class="wrapper">
		
		<?php
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/header.php');
		require($_SERVER['DOCUMENT_ROOT'].'/includes/common/sidebar.php');
		?>

		<!-- CONTENT -->
		<div class="content-wrapper">
			
			<!-- CONTENT HEADER -->
			<section class="content-header">
				<div class="container-fluid">
					
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><i class="far fa-building mr-3"></i><?php echo renderLang($calendar_calendar); ?></h1>
						</div>
					</div>
					
				</div><!-- container-fluid -->
			</section><!-- content-header -->

			<!-- Main content -->
			<section class="content">

                <div class="container-fluid">
                
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo renderLang($calendar_calendar); ?></h3>
                        </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    <label for="">COLOR CODE</label>
                                    <ul>
                                        <?php if(checkPermission('calendar-other-task')) { ?>
                                            <li><span class="badge badge-info"><?php echo renderLang($po_other_task); ?></span></li>
                                        <?php } ?>
                                        <?php if(checkPermission('calendar-work-order')) { ?>
                                            <li><span class="badge badge-warning"><?php echo renderLang($work_order); ?></span></li>
                                        <?php } ?>
                                        <?php if(checkPermission('calendar-venue-reservation')) { ?>
                                            <li><span class="badge badge-success"><?php echo renderLang($reservation); ?></span></li>
                                        <?php } ?>
                                    </ul>
                                </div>

                                <div class="col-12">

                                    <div class="card card-primary">
                                        <div class="card-body p-0">
                                            <!-- THE CALENDAR -->
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </section><!-- content -->
			
		</div>
		<!-- /.content-wrapper -->

		<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/footer.php'); ?>
		
	</div><!-- wrapper -->

  <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- full calendar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="/plugins/calendar/fullcalendar/fullcalendar.min.js"></script>

  <script>
  $(function(){

    [
        {
          title          : 'Click for Google',
          start          : new Date(y, m, 11),
          end            : new Date(y, m, 11),
          url            : 'http://google.com/',
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
        }
      ]
    

  /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear();

    

    <?php
    $events = array();

    // work order
    if(checkPermission('work-order-calendar')) {

        $sql = $pdo->prepare("SELECT * FROM task_work_order WHERE temp_del = 0");
        $sql->execute();
        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            $events[] = array(
                'title' => renderLang($nature_of_job_arr[$data['work_order_nature']]),
                'start' => $data['work_order_date'],
                'end' => $data['work_order_date'],
                'url' => '/work-order/'.$data['id'],
                'backgroundColor' => '#ffc107'
            );
        }

    }

    // pre operation other tasks
    if(checkPermission('calendar-other-task')) {

        $sql = $pdo->prepare("SELECT * FROM other_tasks WHERE temp_del = 0");
        $sql->execute();
        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            $events[] = array(
                'title' => $data['title'],
                'start' => formatDate($data['date'], true, false),
                'end' => formatDate($data['date'], true, false),
                'url' => '/add-activities-pre-operation-other-task/'.$data['id'],
                'backgroundColor' => '#17a2b8'
            );
        }
    
    }

    // Venue Reservation
    if(checkPermission('calendar-venue-reservation')) {

        $sql = $pdo->prepare("SELECT * FROM boardrooms WHERE temp_del = 0 AND status = 1");
        $sql->execute();
        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

            $title = $data['department'].' ['.$data['purpose'].']';

            $events[] = array(
                'title' => $title,
                'start' => formatDate($data['date_reserve'], false, false).' '.$data['time_from'],
                'end' => formatDate($data['date_reserve'], false, false).' '.$data['time_to'],
                'url' => '/boardroom/'.$data['id'],
                'backgroundColor' => '#28a745'
            );
        }

    }
    ?>

    var events = <?php echo json_encode($events); ?>;

    console.log(events);
    

    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
      events    : events,
      editable  : false,
      droppable : false, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')
        copiedEventObject.url             = '/task/'+$(this).data('id');

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // // is the "remove after drop" checkbox checked?
        // if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          var id = $(this).data('id');
          $(this).remove()
        // }

      }
    })

  })
  </script>
	
</body>

</html>
<?php
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1); // "You are not authorized to access the page or function."
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page
	
	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	header('location: /');
	
}
?>