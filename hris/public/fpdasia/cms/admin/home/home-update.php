<?php 
	session_start();
	include __DIR__."/../../config.php";

	if ($_COOKIE['role']!='Admin') {
		header('location: ../../login.php');
	}
	if(empty($_COOKIE['idname'])) {
		header('location: ../../login.php');
	}

	function updateTable_homepage($content, $name){
		$sql = "
			UPDATE 
				`table_homepage` 
			SET 
				`content` = '$content',
				`date_updated` = CURRENT_TIMESTAMP()
			WHERE 
				`name` = '$name'
		";
		$result = mysqli_query($GLOBALS['con'], $sql);
	}

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$main_company_description = $_POST['main_company_description'];
		$short_company_description = $_POST['short_company_description'];
		$homepage_banner = $_POST['homepage_banner'];
		$homepage_vertical_banner = $_POST['homepage_vertical_banner'];
		$consulting_description = $_POST['consulting_description'];
		$audit_description = $_POST['audit_description'];
		$real_estate_management_description = $_POST['real_estate_management_description'];
		$engineering_description = $_POST['engineering_description'];
		$secondary_banner = $_POST['secondary_banner'];
		$service_excellence_description = $_POST['service_excellence_description'];

		$homepage_assets = array(
			"main_company_description" => $main_company_description,
			
		);

		updateTable_homepage($short_company_description, "test");
	}
 ?>