<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../config.php');



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['job_id']) && is_numeric($_GET['job_id']))

{

// get id value

$job_id = $_GET['job_id'];



// delete the entry

$result = mysqli_query($con,"DELETE FROM table_job WHERE job_id=$job_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: careers.php?success_delete");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: careers.php?failed");

}



?>