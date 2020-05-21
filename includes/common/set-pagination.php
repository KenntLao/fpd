<?php
$numrows = $_SESSION['sys_data_per_page']; // set number of rows to display

$page_ctr = 1; // set as default page count
if(isset($_GET['p'])) { // check if pagination is clicked
	$page_ctr = $_GET['p'];
}
$sql_start = $numrows * ($page_ctr-1); // set start of LIMIT statement

// get number of users for pagination
if($page == 'properties') {

	if(isset($properties_type) && $properties_type == 'employee') {

		$total_data_count = $property_count;
		$page_count = ceil($total_data_count/$numrows);

	} else {

		$sql = $pdo->prepare($sql_query);
		$sql->execute();
		$total_data_count = $sql->rowCount(); // get number of rows
		$page_count = ceil($total_data_count/$numrows); // compute for number of pages

	}

} else {

	$sql = $pdo->prepare($sql_query);
	$sql->execute();
	$total_data_count = $sql->rowCount(); // get number of rows
	$page_count = ceil($total_data_count/$numrows); // compute for number of pages

}
?>