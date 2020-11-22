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

  <!-- 1. Add latest jQuery and fancybox files -->

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</head>
<body class="bg-light">
      <!--Navigation-bar-->
  <?php include('navigation-bar.php') ?>
         <div class="container">
  <?php
      
    $views=0;
    if (isset($_GET['album'])) {
         $views = $_GET['album'];
          }

          $sql = "SELECT * FROM table_gallery WHERE album_deleted IS NULL and gallery_id = '$views'";

      $result = mysqli_query($con, $sql);
      
      while($fetch = mysqli_fetch_array($result)){
          $gallery_name =$fetch['gallery_name'];
          $gallery_date =$fetch['gallery_date']
    ?>



          <h3 style="margin-top: 8%;"><?php echo $gallery_name; ?></h3>
          <p class="text-muted"><?php echo date('F, Y', strtotime($gallery_date)); ?></p><br>
           <?php  } ?>
          <div class="row">
    <?php
    $view=0;
    if (isset($_GET['album'])) {
         $view = $_GET['album'];
          }

          $sql = "SELECT * FROM table_gallery_images JOIN table_gallery ON table_gallery_images.gallery_id = table_gallery.gallery_id WHERE table_gallery_images.image_deleted IS NULL and table_gallery.gallery_id =$view ORDER BY id DESC ";

      $result = mysqli_query($con, $sql);

      while($fetch = mysqli_fetch_array($result)){
          $images = $fetch['images'];

    ?>  
  <div class="col-sm-6 col-md-4" data-aos="fade-up"
     data-aos-duration="1000">
    <a data-fancybox="gallery" href="cms/admin/gallery/<?php echo $images; ?>" class="nav-link text-dark">
    <div class="content text-center">
      <img src="cms/admin/gallery/<?php echo $images; ?>" width="100%">
      <p class="font-weight-bold">
        </p>
      <p class="text-secondary" style="margin:1px;"> 
        </p>
    </div></a>
  </div>
                
            <?php
        }
        ?>
  </div>
  <!--View More button-->
 <div class="m-4">   
    <a href="gallery-all-album.php?album" class="btn btn-danger m-left">View More Album</a>
 </div>
  </div>



<br><br>
<!--Contact Us Section-->    
<!--Footer Section-->
  <?php include 'global-footer.php'; ?>

</body>
</html>
<script type="text/javascript">
  $("#upfile1").click(function () {
    $("#file1").trigger('click');
});
</script>
