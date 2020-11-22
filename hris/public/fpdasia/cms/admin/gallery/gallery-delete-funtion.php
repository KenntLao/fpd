<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../../config.php');



// check if the 'id' variable is set in URL, and check that it is valid
$gallery_id=0;
if (isset($_GET['gallery_id']) && is_numeric($_GET['gallery_id']))
{
// get id value
$gallery_id = $_GET['gallery_id'];



// delete the entry
$result = mysqli_query($con,"DELETE * FROM  table_gallery_images JOIN table_gallery ON table_gallery_images.gallery_id = table_gallery.gallery_id WHERE table_gallery.gallery_id=$gallery_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: events.php?success");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: events.php?failed");

}



?>