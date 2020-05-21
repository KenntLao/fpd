<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	$id = $_GET['id'];
	$selected_yrmo = $_GET['yrmo'];

	$sql = $pdo->prepare("SELECT * FROM time_logs WHERE employee_id = ".$id." AND date_code LIKE '".$selected_yrmo."%' ORDER BY id DESC");
	$sql->execute();
	if($sql->rowCount() == 0) {
		echo '<tr><td colspan="4">'.renderLang($lang_no_data_display).'</td></tr>';
	} else {
		while($data = $sql->fetch(PDO::FETCH_ASSOC)) {

			echo '<tr>';

				// DATE
				echo '<td>'.date('F j, Y',$data['time_in']).'</td>';

				// TIME IN
				echo '<td class="text-center">'.date('g:i:s a',$data['time_in']).'</td>';

				// TIME OUT
				echo '<td class="text-center">';
					if($data['time_out'] != 0) {
						echo date('g:i:s a',$data['time_out']);
					} else {
						echo '-';
					}
				echo '</td>';

				// TIME RENDERED
				echo '<td class="text-center">';

					// check if employee is timed out or in
					if($data['time_out'] != 0) {
						$time_out = $data['time_out'];
					} else {
						$time_out = time(); // set current time is still timed in
					}

					// render time in readable format
					if($data['time_rendered'] != 0) {
						$time_rendered = $data['time_rendered'];
					} else {
						$time_rendered = $time_out - $data['time_in'];
					}

					if($time_rendered < 60) {

						echo $time_rendered.'s';

					} elseif($time_rendered < 3600) {

						$time_min = floor($time_rendered/60);
						$time_sec = $time_rendered - ($time_min*60);
						echo $time_min.'m ';
						if($time_sec > 0) {
							echo $time_sec.'s';
						}

					} else {

						$time_hr = floor($time_rendered/3600);
						$time_min = floor(($time_rendered - ($time_hr*3600)) / 60);
						$time_sec = $time_rendered - ($time_min*60) - ($time_hr*3600);
						echo $time_hr.'h ';
						if($time_min > 0) {
							echo $time_min.'m ';
						}
						if($time_sec > 0) {
							echo $time_sec.'s';
						}

					}

				echo '</td>';

			echo '</tr>';
		}
	}
	
	?>
	<script>
		hideLoading();
	</script>
	<?php
	
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4); // "Session not found.<br>Please login to create one."
	?>
	<script>
		window.location = '/'
	</script>
	<?php

}
?>