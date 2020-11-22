<?php

/*

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('../../config.php');
$gal=0;
if (isset($_GET['gallery_id'])) {
	$gal=$_GET['gallery_id'];
}
// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['image_id']) && is_numeric($_GET['image_id']))
{

// get id value

$image_id = $_GET['image_id'];



// delete the entry

$result = mysqli_query($con,"UPDATE table_gallery_images SET image_deleted = now() WHERE id=$image_id")

or die(mysqli_error());



// redirect back to the view page

header("Location: gallery-edit.php?gallery_id=$gal");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: gallery.php?error");

}



?>