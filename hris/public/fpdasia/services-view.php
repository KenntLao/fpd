<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('google-analytics.php') ?>
</head>
<style type="text/css">
 @media only screen and (max-width: 767px){
  .center{
    margin-left: 140px;
    margin-bottom: 9px;

  }
  .tuw{
    text-align: center;
  }
 }
  @media only screen and (max-width: 320px){
  .center{
    margin-left: 98px;

  } }

  .limit-2 {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    line-height: 21px;
    max-height: 48px;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
 }
</style>
<body>
 		  <!--About page Section-->
	<?php include('navigation-bar.php') ?>

 <br><br><br>
 <?php
 include __DIR__."/cms/config.php";
      
    $views=0;
    if (isset($_GET['view_id'])) {
         $views = $_GET['view_id'];
          }

          $sql = "SELECT * FROM table_services WHERE services_deleted IS NULL and services_id = '$views'";

      $result = mysqli_query($con, $sql);
      
      $fetch = mysqli_fetch_array($result);
          $services_image =$fetch['services_image'];
          $services_name =$fetch['services_name'];
          $services_details =$fetch['services_details'];
    ?>
<div class="container mx-auto" >
  <div class="row">
    <div class="col-sm-12"> 
      <div class="row">
        <img class="mx-auto" src="cms/admin/services/services/<?php echo $services_image; ?>">
      </div> <br> 
        <h3 class=" text-center font-weight-bold ">
        <?php echo $services_name; ?>
        </h3>
        <p class="text-justify px-2"><?php echo $services_details; ?><br></p>
    </div>
    </div>
</div> <br><br>
<!--other services Section-->
<div class="container">
  <div class="row justify-content-center text-center">

<?php

       $sql = "SELECT * FROM table_services WHERE services_id !='$views' and services_deleted IS NULL and  services_id ORDER BY services_id DESC ";
      $result = mysqli_query($con, $sql);


        while($fetch = mysqli_fetch_array($result)){
          $services_image = $fetch['services_image'];
          $services_name = $fetch['services_name'];
          $services_short_details = $fetch['services_short_details'];
    ?>

    <div class="col-md-4 col-lg-4 mb-3">
      <div class="p-3 h-100 shadow rounded">
        <img class="py-3" src="cms/admin/services/services/<?php echo $services_image; ?>" width="20%">
        <h5 class="card-title text-center font-weight-bold"><?php echo $services_name; ?></h5>
        <p class="limit-2"><?php echo $services_short_details; ?></p>
        <?php 
        echo '<a href="services-view.php?view_id=' . $fetch['services_id'] . '" class="nav-link text-danger">Read More</a>';
         ?>
      </div>
    </div>
    <?php } ?>

  </div>
</div><br>
   <!--Contact Us Section-->
  <!--Footer Section-->
   <?php include('global-footer.php'); ?>

</body>
</html>