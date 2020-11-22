<?php 
  include __DIR__."/cms/config.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="fpdasia-css/index.css">
  <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
   <!-- 1. Add latest jQuery and fancybox files -->

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<?php include('google-analytics.php') ?>
</head>
<style type="text/css">
.container-gallery{
  margin-top:5%;
  width: 200px;
  
  
}
  .t-style{
    width:65%;
    display: inline-block;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }
  .t-style2{

    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
  .paper {
  background-color: #fff;
  /* Need position to allow stacking of pseudo-elements */
  position: relative;
  /* Padding for demo purposes */
}

.paper,
.paper::before,
.paper::after {
  /* Add shadow to distinguish sheets from one another */
  box-shadow: 2px 1px 1px rgba(0,0,0,0.15);
}

.paper::before,
.paper::after {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #eee;
}

/* Second sheet of paper */
.paper::before {
  left: 7px;
  top: 5px;
  z-index: -1;
}

/* Third sheet of paper */
.paper::after {
  left: 12px;
  top: 10px;
  z-index: -2;
}
.nav-links:hover{
  background-color: #f2f2f2;
}
.card2{
  height: 320px;
}
@media only screen and (max-width: 575px){
  .card2{
  height: 100%;
}
  }
</style>
<body class="bg-light">
      <!--About page Section-->
  <?php include('navigation-bar.php') ?><br><br>

<div class="container my-3">
  <div class="gif_container" style="width: 15%">
    <img src="gif/Gallery.gif" width="100%">
  </div>
<div class="row">
<div class="col-md col-md col-lg">
  <div class="row">


    

        
<?php


if (isset($_GET['albums'])) {
$album=0;
if (isset($_GET['album'])) {
$album = $_GET['album'];
 }
?>

<!-- container preview -->
<?php

$sql = "SELECT * FROM table_gallery WHERE album_deleted IS NULL ORDER BY gallery_date DESC LIMIT 6";
$result = mysqli_query($con, $sql);

while($fetch = mysqli_fetch_array($result)){

$gallery_image = $fetch['gallery_image'];
$gallery_id=$fetch['gallery_id'];
$gallery_name=$fetch['gallery_name'];
$gallery_date=$fetch['gallery_date'];

    echo '<div class="col-sm-6 col-md-4 " data-aos="zoom-in-up">
          <div class=" my-4">
          <div class="card card2 paper">
          <img src="cms/admin/gallery/'.$gallery_image.'" class="card-img-top img-thumbnail">
          <div class="card-body">
          <a class="nav-link" href="gallery-view.php?album='.$gallery_id.'">
          <h5 class="t-style2">'.$gallery_name.'</h5>
          </a>
          <small class="small text-muted ">';

    echo date('F, Y', strtotime($gallery_date));

    echo' </small>
          </div>
          </div>
          </div>
          </div>';
}
}
?>


<?php
$gal_id = 0;
if (isset($_GET['gal_id'])) {
$gal_id = $_GET['gal_id'];
          }

 $sql = "SELECT * FROM table_gallery_images WHERE image_deleted IS NULL and gallery_id =$gal_id ORDER BY id DESC ";
 $sqls="SELECT * FROM table_gallery WHERE album_deleted IS NULL and gallery_id =$gal_id";

 $results = mysqli_query($con, $sqls);
 $fetchs = mysqli_fetch_array($results);
    $gallery_name = $fetchs['gallery_name'];

    echo "<div class='col-sm-12 '><h4>".$gallery_name."</h4></div>";


$result = mysqli_query($con, $sql);
while($fetch = mysqli_fetch_array($result)){
            $images = $fetch['images'];
  ?>
            
<div class="col-sm-6 col-md-4 ">
<a data-fancybox="gallery" href="cms/admin/gallery/<?php echo $images; ?>" class="nav-link text-dark">
<div class="content text-center">
<img src="cms/admin/gallery/<?php echo $images; ?>" width="100%">
</div>
</a>
</div> 

<?php } ?>
  </div>
 <!--View More button-->
 <div class="my-4">   
    <a href="gallery-all-album.php?album" class="btn btn-danger m-left">View More Album</a>
 </div>

</div>
<br>



  <!--accordion-->
  <div class="col-md-3 col-lg-3 mx-auto ">
  <div class=" py-5 container card rounded">
  
  <h3 class="text-center text-blue">Gallery Archive</h3>
  <small class="text-center text-muted mb-3">Click the year to see the albums...</small>

  <div class="accordion" id="accordionExample">

<!--first Accordion-->
  <div id="headingTwo" class="border-bottom ">
  <a href="" class="btn-link m-2 py-2" data-toggle="collapse" data-target="#collapseTwo">2019</a>
  </div>
  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
  <div class="card-body">
<?php 

   $sql = "SELECT * FROM table_gallery WHERE album_deleted IS NULL and gallery_date LIKE '%2019%' ORDER BY gallery_id DESC";
      $result = mysqli_query($con, $sql);

        while($fetch = mysqli_fetch_array($result)){
          $gallery_image = $fetch['gallery_image'];
          $gallery_id=$fetch['gallery_id'];
          $gallery_name=$fetch['gallery_name'];

            echo '<a class="nav-link nav-links text-secondary" href="gallery.php?gal_id='.$gallery_id.'">
                 <img src="cms/admin/gallery/'.$gallery_image.'" width="25%">
                 <span style="vertical-align: middle;">
                 <div class="t-style">'.$gallery_name.'</div>
                 </span>
                 </a>';
}?>
                   
  </div>
  </div>
<!--end first Accordion-->

<!--second Accordion-->       
  <div id="headingOne"  class="border-bottom ">
  <a href=""  class="btn-link m-2 py-2" data-toggle="collapse"  data-target="#collapseOne">2018</a>                  
  </div>
  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
  <div class="card-body">
  <?php 

    $sql = "SELECT * FROM table_gallery WHERE album_deleted IS NULL and gallery_date LIKE '%2018%' ORDER BY gallery_id DESC";
      $result = mysqli_query($con, $sql);

        while($fetch = mysqli_fetch_array($result)){
          $gallery_image = $fetch['gallery_image'];
          $gallery_id=$fetch['gallery_id'];
          $gallery_name=$fetch['gallery_name'];

    echo '<a class="nav-link nav-links text-secondary" href="gallery.php?gal_id='.$gallery_id.'">
          <img src="cms/admin/gallery/'.$gallery_image.'" width="25%">
          <span style="vertical-align: middle;">
          <div class="t-style">'.$gallery_name.'</div>
          </span>
          </a>';
}?>


  </div>
  </div>
<!--end second Accordion-->

<!--third Accordion--> 
  <div id="headingThree"  class="border-bottom ">
  <a href="" class="btn-link m-2 py-2" data-toggle="collapse" data-target="#collapseThree">2017</a>                     
  </div>
  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
  <div class="card-body">
  <?php 

    $sql = "SELECT * FROM table_gallery WHERE album_deleted IS NULL and gallery_date LIKE '%2017%' ORDER BY gallery_id DESC";
      $result = mysqli_query($con, $sql);

        while($fetch = mysqli_fetch_array($result)){
          $gallery_image = $fetch['gallery_image'];
          $gallery_id=$fetch['gallery_id'];
          $gallery_name=$fetch['gallery_name'];
              echo '<a class="nav-link nav-links text-secondary" href="gallery.php?gal_id='.$gallery_id.'">
                    <img src="cms/admin/gallery/'.$gallery_image.'" width="25%">
                    <span style="vertical-align: middle;">
                    <div class="t-style">'.$gallery_name.'</div>
                    </span>
                    </a>';
}?>

  </div>
  </div>
  <!--end third Accordion--> 

  </div>
  </div>
  </div>
    <!--accordion end-->
    </div>

    </div>
 
  <!--Contact Us Section--><br>  
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>
