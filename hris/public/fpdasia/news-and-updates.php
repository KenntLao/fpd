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
  .limit-2 {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
 }
</style>
<body class="bg-light">
      <!--Navigation-bar-->
  <?php 
        include __DIR__."/cms/config.php"; 
        include('navigation-bar.php');
  ?>

  <div>
    <img src="Assets/News&Updates/News&Updates-Banner.jpg" width="100%">
  </div>

      <main role="main" class="container mt-4">
  <div class="row">

    <div class="col-md-8 blog-main">
        <h2  class="text-center mb-2" id="featured"> 
      <b>
        <span class="text-danger">News</span> & <span class="text-danger">Updates </span>
      </b>
        </h2>
      <div class="blog-post">
        <!------------  featured news  ---------------->
    <?php

     $news=2;
    if (isset($_GET['news'])) {
         $news = $_GET['news']; 
               

        }
 
        $sql = "SELECT * FROM table_news_and_updates WHERE nu_deleted IS NULL AND nu_id='$news'  ORDER BY nu_date DESC limit 1";
        $result = mysqli_query($con, $sql);


        $fetch = mysqli_fetch_array($result);
            $nu_image = $fetch['nu_image'];
            $nu_name = $fetch['nu_name'];
            $nu_date = $fetch['nu_date'];
            $nu_link = $fetch['nu_link'];
            $nu_name_link = $fetch['nu_name_link'];
            $nu_id = $fetch['nu_id'];
            $nu_details = $fetch['nu_details'];
            $nu_short_details = $fetch['nu_short_details'];

            ?>
            
  <div class="container shadow bg-white rounded">
<div class="row py-3">
        <div class="m-1 col-lg-12">
          <!--title-->
      <h3 class="text-danger mb-0" ><b><?php echo $nu_name; ?></b></h3>
      <small class="text-secondary mt-o pt-0">
    <?php echo date('F j, Y', strtotime($nu_date)); ?>
    <a href="<?php echo $nu_link; ?>" target="_blank" class="limit-2"><?php echo $nu_name_link; ?></a>
  </small>
      <!--end title-->
        </div>
      <div class="col-sm-12" >
      <img src="cms/admin/news-and-updates/news-and-updates/<?php echo $nu_image; ?>" width="80%" class="mx-5">
      </div>

      <div class="col-sm-12">
      
      <!--body-->
      <p class="text-justify mx-4 my-3"><?php echo $nu_short_details; ?><br><br>
      <?php echo $nu_details; ?>
      </p>
      <!--end body-->
            <a href="news-and-updates-view.php" class="text-uppercase nav-link text-danger font-weight-bold">
              Read More News & Updates &nbsp;
            <i class='fas fa-arrow-circle-right' style='font-size:20px'></i>
      </a>

      </div>
</div>
</div><br>

     
      </div><!-- /.blog-post -->

    </div><!-- /.blog-main -->

    <aside class="col-md-4 blog-sidebar">
      <h5 class="text-center font-weight-bold">Archives</h5>

    <div class="mb-3 row" >
    <?php   

        

     $sql = "SELECT * FROM table_news_and_updates WHERE nu_deleted IS NULL and nu_date ORDER BY nu_date DESC limit 6";
    $result = mysqli_query($con, $sql);
      while($fetch = mysqli_fetch_array($result)){
        $nu_image = $fetch['nu_image'];
        $nu_name = $fetch['nu_name'];
        $nu_date = $fetch['nu_date'];
        $nu_id =$fetch['nu_id'];
        $nu_category =$fetch['nu_category'];
        $nu_details =$fetch['nu_details'];
        $nu_link = $fetch['nu_link'];            
        $nu_name_link = $fetch['nu_name_link'];

    ?>
    <span class="col-md-5 mb-1">
      <a href="news-and-updates.php?news=<?php echo $nu_id; ?>" class="text-dark">
    <img src="cms/admin/news-and-updates/news-and-updates/<?php echo $nu_image; ?>" width="100%">
    </span>
    <div class="col-md-7">
    <p>
    <span class="limit-2"><?php echo $nu_name; ?></span>
    <small class="text-secondary">
    <?php echo date('F j, Y', strtotime($nu_date)); ?>
    <a href="<?php echo $nu_link; ?>" target="_blank" class="text-primary"><?php echo $nu_name_link; ?></a>
  </small>
   </a> 
    </p>
    </div>
                
    <?php } ?>
        
    </div>


    </aside><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</main><!-- /.container -->

  <!--Contact Us Section-->   
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>

