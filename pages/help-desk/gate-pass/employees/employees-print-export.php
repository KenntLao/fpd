<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('gate-pass-employees')) {

    $id = $_GET['id'];

    $filename = 'pass-control-employees-'.time();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($gate_pass_employees); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
</head>
<body>

    <div class="container">
        
        <div class="mt-3">
            <h3><?php echo renderLang($gate_pass_employees); ?></h3>
        </div>
    
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th><?php echo renderLang($gate_pass_employees_project_name); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_date_employee); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_employee_name); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_purpose); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_person_department); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_time_in); ?></th>
                    <th><?php echo renderLang($gate_pass_employees_time_out); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($_SESSION['sys_account_mode'] == 'user') {
                    
                    $sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 ORDER BY g.date ASC ");
                    $sql->execute();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                            if (empty($data['property_id'])) {

                                $project_code = getField('reference_number','prospecting','id ='.$data['prospect_id']);
                                
                                echo '<td>'.(!empty($data['prospect_id']) ? $data['property_name'].' ['.$project_code.']' : '').'</td>';

                            } else {

                                $property_code = getField('property_id','properties','id ='.$data['property_id']);
                                
                                echo '<td>'.(!empty($data['property_id']) ? $data['property_name'].' ['.$property_code.']' : '').'</td>';

                            }
                            echo '<td>'.formatDate($data['date']).'</td>';
                            echo '<td>'.$data['employee_name'].'</td>';
                            echo '<td>'.$data['purpose'].'</td>';
                            echo '<td>'.$data['person_department'].'</td>';
                            echo '<td>'.$data['time_in'].'</td>';
                            echo '<td>'.$data['time_out'].'</td>';
                        echo '</tr>';
                    }
                } else {

                    $property_ids = get_user_cluster_data($_SESSION['sys_id'])['properties'];

                    $ub_properties = implode(',',$property_ids);
                    
                    $sql = $pdo->prepare("SELECT g.id, g.date, g.employee_name, g.purpose, g.time_in, g.time_out, g.person_department, g.prospect_id, g.property_id, p.property_name FROM gate_pass_employees g LEFT JOIN properties p ON (g.property_id = p.id) WHERE g.temp_del = 0 AND g.property_id IN ($ub_properties) ORDER BY g.date ASC ");
                    $sql->execute();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                            if (empty($data['property_id'])) {

                                $project_code = getField('reference_number','prospecting','id ='.$data['prospect_id']);
                                
                                echo '<td>'.(!empty($data['prospect_id']) ? $data['property_name'].' ['.$project_code.']' : '').'</td>';

                            } else {

                                $property_code = getField('property_id','properties','id ='.$data['property_id']);
                                
                                echo '<td>'.(!empty($data['property_id']) ? $data['property_name'].' ['.$property_code.']' : '').'</td>';

                            }
                            echo '<td>'.formatDate($data['date']).'</td>';
                            echo '<td>'.$data['employee_name'].'</td>';
                            echo '<td>'.$data['purpose'].'</td>';
                            echo '<td>'.$data['person_department'].'</td>';
                            echo '<td>'.$data['time_in'].'</td>';
                            echo '<td>'.$data['time_out'].'</td>';
                        echo '</tr>';
                    }

                }
                ?>
            </tbody>
        </table>

    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/js.php'); ?>
    <script src="/plugins/table2excel/jquery.table2excel.min.js"></script>
    <script>
    $(function(){
        
        <?php if($id == 0) { ?>
            // print
            $(window).on('load', function() {
                window.print();
            });

        <?php } ?>

        <?php if($id == 1) { ?>
            // export
            var filename = '<?php echo $filename; ?>';
            $("table.table").table2excel({
                name: "Pass Control Employees",
                filename: filename,
                fileext: ".xls"
            });

            window.location.href = "/gate-pass-employees";
        <?php } ?>

    });
    </script>

</body>
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