<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
<?php include('google-analytics.php') ?>
</head>
<style type="text/css">
  .round{
    border-radius: 12px;
  }
  .brs{
    margin-top: 3.2%;
  }
</style>

<body class="bg-light">
      <!--Navigation-bar-->
  <?php include('navigation-bar.php') ?>

  <div  class="brs">
    <img src="Assets/Careers/Join our Team-Banner.jpg" width="100%">
  </div>

 

  <div class="container">
        <div class="row">
          <?php
      include __DIR__."/cms/config.php";

      $job=0;

    if (isset($_GET['job'])) {
         $job = $_GET['job']; }

      $sql = "SELECT * FROM table_job WHERE enabled = 'enabled' and job_id=$job ORDER BY job_id DESC ";
      $result = mysqli_query($con, $sql);


        while($fetch = mysqli_fetch_array($result)){
          $job_image = $fetch['job_image'];
          $job_icon = $fetch['job_icon'];
          $job_name = $fetch['job_name'];
          $job_details = $fetch['job_details'];
          $job_identification=$fetch['job_identification'];
        $job_specification=$fetch['job_specification'];
        $job_duty_respo=$fetch['job_duty_respo'];
      
    ?>

            
            <div class="col-sm-12 col-md-5">
            <img class="py-2 mx-4" src="cms/admin/careers/job-icon/<?php echo $job_icon; ?>" width="20%">
             <h5 class="card-title font-weight-bold text-uppercase"><?php echo $job_name; ?></h5>
             <p class="limit-2 px-2 py-3"><?php echo $job_details; ?></p>
             <a href="careers-application.php?job=<?php echo $job_name; ?>" class="btn btn-danger mb-2">Apply Now</a>
          </div>

          <div class="col-sm-12 col-md-7">
            <img class="py-2" src="cms/admin/careers/job-image/<?php echo $job_image; ?>" width="90%">
          </div><br><br>

          <div class="col-sm-12 col-md-6">

            <div class="bg-white px-4 py-3 my-2 round">
              <p class="mx-2">
                <h3 class="font-weight-bold text-danger mx-4">Job Identification</h3>
                <?php echo $job_identification; ?>
              </p>
            </div>

          </div>
          <div class="col-sm-12 col-md-6">

            <div class="bg-white px-4 py-3 my-2 round">
              <p class="mx-2">
                <h3 class="font-weight-bold text-danger mx-4">Job Specification</h3>
                <?php echo $job_specification; ?>
              </p>
            </div>

          </div>
          <div class="col-sm-12 mt-2">
             <div class="px-4  bg-white py-3 round">
              <h3 class="font-weight-bold text-danger mx-4">Job Duty & Reponsibilities</h3>
              <p class="px-5">
            <?php echo $job_duty_respo; ?>
            </p>
            </div>
          </div>
          

           <?php } ?>

          <a href="careers.php" class="btn btn-outline-danger my-4 px-5">View Other Position</a>
        </div>
  </div>
<br><br>
  <!--Contact Us Section-->  
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>

