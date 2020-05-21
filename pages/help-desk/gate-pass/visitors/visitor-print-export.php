<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {
	
	// check permission to access this page or function
	if(checkPermission('visitors')) {

    $id = $_GET['id'];

    $filename = 'visitors-'.time();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo renderLang($visitors); ?> &middot; <?php echo $sitename; ?></title>
	
	<?php require($_SERVER['DOCUMENT_ROOT'].'/includes/common/links.php'); ?>
	
</head>
<body>

    <div class="container">
        
        <div class="mt-3">
            <h3><?php echo renderLang($visitors); ?></h3>
        </div>
    
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th><?php echo renderLang($daily_collections_daily_collection_building); ?></th>
                    <th><?php echo renderLang($lang_date); ?></th>
                    <th><?php echo renderLang($time_time_in); ?></th>
                    <th><?php echo renderLang($time_time_out); ?></th>
                    <th><?php echo renderLang($visitors_name_of_visitor); ?></th>
                    <th><?php echo renderLang($visitors_company_address); ?></th>
                    <th><?php echo renderLang($visitors_person_to_visit); ?></th>
                    <th><?php echo renderLang($visitors_purpose); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($_SESSION['sys_account_mode'] == 'user') {

                    $sql = $pdo->prepare("SELECT v.date, v.time_in, v.time_out, v.name_of_visitor, v.company_address, v.person_to_visit, v.purpose, v.purpose_others, v.id, v.sub_property_id, sp.sub_property_name, p.property_name FROM visitors v LEFT JOIN sub_properties sp ON (v.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE v.temp_del = 0 ORDER BY v.time_in ASC");
                    $sql->execute();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                            echo '<td>'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</td>';
                            echo '<td>'.formatDate($data['date']).'</td>';
                            echo '<td>'.$data['time_in'].'</td>';
                            echo '<td>'.$data['time_out'].'</td>';
                            echo '<td>'.$data['name_of_visitor'].'</td>';
                            echo '<td>'.$data['company_address'].'</td>';
                            echo '<td>'.$data['person_to_visit'].'</td>';
                            if ($data['purpose'] != 'Others') {

                                // purpose
                                echo '<td>'.$data['purpose'].'</td>';

                            } else{

                                // purpose
                                echo '<td>'.$data['purpose_others'].'</td>';

                            }
                        echo '</tr>';
                    }
                } else {

                    $sub_property_ids = get_user_cluster_data($_SESSION['sys_id'])['sub_properties'];

                    $ub_properties = implode(',',$sub_property_ids);

                    $sql = $pdo->prepare("SELECT v.date, v.time_in, v.time_out, v.name_of_visitor, v.company_address, v.person_to_visit, v.purpose, v.purpose_others, v.id, v.sub_property_id, sp.sub_property_name, p.property_name FROM visitors v LEFT JOIN sub_properties sp ON (v.sub_property_id = sp.id) LEFT JOIN properties p ON (sp.property_id = p.id) WHERE v.temp_del = 0 AND v.sub_property_id IN ($ub_properties) ORDER BY v.time_in ASC");
                    $sql->execute();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                            echo '<td>'.(checkVar($data['sub_property_id']) ? $data['sub_property_name'].' ['.$data['property_name'].']' : '').'</td>';
                            echo '<td>'.formatDate($data['date']).'</td>';
                            echo '<td>'.$data['time_in'].'</td>';
                            echo '<td>'.$data['time_out'].'</td>';
                            echo '<td>'.$data['name_of_visitor'].'</td>';
                            echo '<td>'.$data['company_address'].'</td>';
                            echo '<td>'.$data['person_to_visit'].'</td>';
                            if ($data['purpose'] != 'Others') {

                                // purpose
                                echo '<td>'.$data['purpose'].'</td>';

                            } else{

                                // purpose
                                echo '<td>'.$data['purpose_others'].'</td>';

                            }
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
                name: "Visitors",
                filename: filename,
                fileext: ".xls"
            });

            window.location.href = "/visitors";
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