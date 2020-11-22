<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../config.php');



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['nu_id']) && is_numeric($_GET['nu_id']))

{

// get id value

$nu_id = $_GET['nu_id'];



// delete the entry

$result = mysqli_query($con,"UPDATE table_news_and_updates SET nu_deleted = now() WHERE nu_id=$nu_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: news-and-updates.php?success_delete");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: news-and-updates.php?failed");

}

?>