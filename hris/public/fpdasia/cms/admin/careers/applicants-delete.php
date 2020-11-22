<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../config.php');


// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['applicant_id']) && is_numeric($_GET['applicant_id']))

{

// get id value

$applicant_id = $_GET['applicant_id'];



// delete the entry

$result = mysqli_query($con,"UPDATE table_careers_application SET deleted_app = now() WHERE careers_app_id=$applicant_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: applicants.php");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: applicants.php?success");

}



?>