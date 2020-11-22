<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../config.php');


// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['pm_id']) && is_numeric($_GET['pm_id']))

{

// get id value

$pm_id = $_GET['pm_id'];



// delete the entry

$result = mysqli_query($con,"UPDATE table_property_management SET pm_deleted = now() WHERE pm_id=$pm_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: property-management.php");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: property-managemen.php?success");

}



?>