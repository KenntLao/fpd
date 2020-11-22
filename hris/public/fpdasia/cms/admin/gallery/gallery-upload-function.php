<?php
include __DIR__."/../../config.php";
if (!isset($_FILES['gallery_image']['tmp_name'])) {
  echo "";
  }else{
  $file=$_FILES['gallery_image']['tmp_name'];
  $image= addslashes(file_get_contents($_FILES['gallery_image']['tmp_name']));
  $image_name= addslashes($_FILES['gallery_image']['name']);
      
      move_uploaded_file($_FILES["gallery_image"]["tmp_name"],"gallery/" . $_FILES["gallery_image"]["name"]);
      
      $gallery_image="gallery/" . $_FILES["gallery_image"]["name"];
      $gallery_date=$_POST['gallery_date'];
      $gallery_name=$_POST['gallery_name'];
      
      $sql=mysqli_query($con,"INSERT INTO table_gallery  (gallery_image,gallery_date,gallery_name) VALUES ('$gallery_image','$gallery_date','$gallery_name')");

      $gallery_id = mysqli_insert_id($con);


        $total = count($_FILES['gallery_images']['name']);

        // Loop through each file
        for( $i=0 ; $i < $total ; $i++ ) {

          //Get the temp file path
          $tmpFilePath = $_FILES['gallery_images']['tmp_name'][$i];

          //Make sure we have a file path
          if ($tmpFilePath != ""){
            //Setup our new file path
            $images = "gallery/" . $_FILES['gallery_images']['name'][$i];

            //Upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $images)) {

              $sql=mysqli_query($con,"INSERT INTO table_gallery_images  (gallery_id,images) VALUES ($gallery_id ,'$images')");

            }
          }
        }

     header("location: gallery.php");
      exit();         
  }
?>

