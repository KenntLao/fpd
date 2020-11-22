<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../config.php');



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['home_slider_id']) && is_numeric($_GET['home_slider_id']))

{

// get id value

$home_slider_id = $_GET['home_slider_id'];



// delete the entry

$result = mysqli_query($con,"DELETE FROM table_home_slider WHERE home_slider_id=$home_slider_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: home-slider.php?success_delete");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: home-slider.php?failed");

}



?>