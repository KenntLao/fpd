<?php  
      include __DIR__."/cms/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
  <link rel="stylesheet" type="text/css" href="/Assets/styles.css">

  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style type="text/css">
.roundeds{
  border-radius: 15px;
}

.gif2{
  width: 25%;
}
</style>
<body class="bg-light">
 		  <!--About page Section-->
	<?php include('navigation-bar.php') ?>

  <div>
    <img src="Assets/Projects/About-Banner.jpg" width="100%">
  </div>


  <div class="container mb-5">
    <h2 class="font-weight-bold text-center mt-2">
  <span><img src="gif/Management.gif" class="gif2"></span>
</h2>

      <p class="text-center text-secondary mrl text-justify">
     FPD Asia currently manages over 70 properties, spanning over 3.5 million square meters of gross floor area. Its managed portfolio consists of the following types of properties:
    </p>

      <div class="row mt-4">

        <?php

          $sql = "SELECT * FROM table_property_management WHERE pm_deleted IS NULL and pm_id ORDER BY pm_name ASC";

      $result = mysqli_query($con, $sql);
      
      while ($fetch = mysqli_fetch_array($result)) {
          $pm_icon =$fetch['pm_icon'];
          $pm_name =$fetch['pm_name'];
          $pm_id =$fetch['pm_id'];
    ?>
        <div class="col-md-6 my-auto">
          <div class=" text-center bg-white roundeds p-5 my-2 shadow text-blue">  
            <a class="text-blue" href="property-management-view.php?pm_id=<?php echo $pm_id; ?>" style="text-decoration: none;">
              <img src="Assets/Projects/<?php echo $pm_icon; ?>" class="mb-3"><br>

              <div class="property_name">
                <h3 class="font-weight-bold">
                  <?php echo $pm_name; ?>
                </h3>
              </div>
            </a>
          </div>
        </div>
        <?php }?>

    </div> 
      </div><br>
 	   <!--Contact Us Section-->
    <!--Footer Section-->  
      <div class="footer-container">
        <?php include('pages/footer.php'); ?>
      </div>

</body>
</html>
