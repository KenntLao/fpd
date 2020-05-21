<?php 
$page_num = 1;
if(isset($_GET['page'])) {
  $page_num = $_GET['page'];
}

// clear button
$redirect_link = $_SERVER['REQUEST_URI']; // current URL
if(isset($page_href)) {
  $redirect_link = $page_href;
}

$qry_limit = $_SESSION['sys_data_per_page']; // set number of rows to display;

$total_page_number = get_total_page_number($total_row, $qry_limit); // set total page number
$qry_start = get_qry_start($qry_limit, $page_num); // get the query start select
$qry_end = $qry_limit + $qry_start;
?>