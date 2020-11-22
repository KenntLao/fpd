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
<?php include('google-analytics.php') ?>
</head>
<style type="text/css">
.roundeds{
  border-radius: 15px;
}
.pd{
	padding-top: 20px;
}
 @media only screen and (max-width: 991px){
 	.pd{
	padding-top: 9px;
}
 }
</style>
<body class="bg-light">
 		  <!--About page Section-->
	<?php include('navigation-bar.php') ?>

  <?php

    $pm=0;
    if (isset($_GET['pm_id'])) {
         $pm = $_GET['pm_id'];
          }

          $sql = "SELECT * FROM table_property_management WHERE pm_deleted IS NULL and pm_id = '$pm'";

          

      $result = mysqli_query($con, $sql);
      
      $fetch = mysqli_fetch_array($result);
          $pm_image =$fetch['pm_image'];
          $pm_name_gif =$fetch['pm_name_gif'];
          $pm_icon =$fetch['pm_icon'];
          $pm_details =$fetch['pm_details'];
          
    ?>



<br>
  <div class="container">
     <div class=" my-4">
        <div class=" text-center text-justify" >
          <div class="gif_container">
            <img src="gif/<?php echo $pm_name_gif; ?>" class="gif2" <?php echo ($pm==3 || $pm==1 ? "width='40%'" : "width='100%'") ?>>
          </div>
        </div>
        <div class="text-center text-justify mrl"><?php echo $pm_details; ?></div>  
        <div  data-aos="zoom-in" data-aos-duration="2000">
        <img src="cms/admin/property-management/pm-image/<?php echo $pm_image; ?>" width="100%" class="p-3">
        </div>

 </div>
 <div class="row">
    <?php 

    	$sql = "SELECT * FROM table_property_management WHERE pm_deleted IS NULL and pm_id !='$pm ' ORDER BY pm_name ASC";

      $result = mysqli_query($con, $sql);
      
      while ($fetch = mysqli_fetch_array($result)) {
          $pm_icon =$fetch['pm_icon'];
          $pm_name =$fetch['pm_name'];
          $pm_id =$fetch['pm_id'];
     ?>

     <div class="col-md-6 col-xs-12 px-4" >
          <div class=" text-center bg-white roundeds p-4 my-2 shadow">  
            <a href="property-management-view.php?pm_id=<?php echo $pm_id; ?>" 
                class="text-danger" style="text-decoration: none;">
          <img src="Assets/Projects/<?php echo $pm_icon; ?>" class="mb-3"><br>

          <h3 class="font-weight-bold">
            <?php echo $pm_name; ?>
          </h3>
            </a>
          </div>
        </div>
        <?php } ?>

  </div>
        <p class="text-center text-secondary mrl  text-justify">
        Property Management is not an auxiliary business for us. It is our core competence & our main line of business. This is what we know. This is what we do. This is where we excel.
      </p>
      <br>
</div>
 	   <!--Contact Us Section-->
<!--Footer Section-->
   <?php include('global-footer.php'); ?>

</body>
</html>
