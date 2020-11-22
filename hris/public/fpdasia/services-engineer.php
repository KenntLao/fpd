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
  <link rel="stylesheet" type="text/css" href="../fpdasia-css/index.css">
<?php include('google-analytics.php') ?>
</head>
<style type="text/css">
.roundeds{
  border-radius: 15px;
}
   .text-r{
    text-align:right;
  }
    .hide{
    display: none;
  }
  @media only screen and (max-width: 991px){
    .text-r{
    text-align:center;
  }
   .hide{
    display: block;
  }
   .hide2{
    display: none;
  }
  }
  .text-ln{
    text-align:left;
  }
 
  @media only screen and (max-width: 991px){
    .text-ln{
    text-align:center;
  }
  .height{
      height: auto;
  }
  }
.display-none{
  display: none;
}
</style>

<body class="bg-light">
 <!--About page Section-->
  <?php include('navigation-bar.php') ?>
  <div><img src="/banner/service-banner.png" width="100%"></div>

<!--Engineering Service-->
  <div class="container mt-3">
    <h2 class="text-danger text-center font-weight-bold" data-aos="zoom-in" data-aos-duration="2000">
      <title>Engineering Service</title>
    </h2>
   
    <div class="row">
      <div class="text-center col-sm-12">
        <?php if (isset($_GET['success'])) {
          echo '<div class="alert alert-success row "><strong class="text-center">
                Thank You! Your Ask for details has been sent. We will get back you the soonest possible
                </strong> .</div>';
                } ?>
      </div><br>
  
    <?php
    $sql = "SELECT * FROM table_engineering_services WHERE es_deleted IS NULL and es_id ORDER BY es_id ASC";

    $result = mysqli_query($con, $sql);
      
    while ($fetch = mysqli_fetch_array($result)) {
        $es_icon =$fetch['es_icon'];
        $es_name =$fetch['es_name'];
        $es_description =$fetch['es_description'];
        $es_id =$fetch['es_id'];
    ?>
    <div class="col-sm-12 col-md-6">
        <div class="p-3 my-2 bg-white roundeds height"> 
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-1">
                    <div class=" row m-1">     
                        <img src="Assets/Services/engineer/<?php echo $es_icon; ?>" class="m-auto">
                    </div>
                </div>
                    <h4 class="col-sm-12 col-md-12 col-lg-7 mb-0 text-ln my-auto">
                        <?php echo $es_name; ?>
                    </h4>

                  <small class="col-sm-12 col-lg-4  text-r hide2 my-auto">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenterEngineer<?php echo $es_id; ?>">
                      Ask for details
                    </button>
                  </small>

                    <div class="col-sm-12 px-4 pt-3 text-ln text-justify">
                      <?php echo $es_description; ?>
                    </div>

                      <small class="hide m-auto">
                        <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenterEngineer<?php echo $es_id; ?>">
                          Ask for details
                        </button>
                      </small>      
            </div>
        </div>
    </div>
  <?php } ?>
  <?php
    $sql = "SELECT * FROM table_engineering_services WHERE es_deleted IS NULL and es_id ORDER BY es_id ASC";
    $result = mysqli_query($con, $sql);
    while ($fetch = mysqli_fetch_array($result)) {
      $es_name =$fetch['es_name'];
      $es_id =$fetch['es_id'];
      ?>
<!-- Modal -->
    <div class="modal fade" id="exampleModalCenterEngineer<?php echo $es_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">
              <b>Ask for details:</b> <?php echo $es_name; ?>  
            </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
        <div class="modal-body">
         <form method="post" action="engineer-email-function.php">
          <div class="form-group display-none">
            <input type="text" name="details_es" value="<?php echo $es_name; ?>" class="form-control" >
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Name <small>(required)</small>:</label>
            <input type="text" name="name_es" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="recipient-email" class="col-form-label">Email <small>(required)</small>:</label>
            <input type="text" name="email_es" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="recipient-phone" class="col-form-label">Phone <small>(Optional)</small>:</label>
            <input type="tel" name="phone_es" class="form-control" >
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <input type="submit" name="submit_engineer" class="btn btn-success" value="Send">
          </div>
        </form>
          </div>
         </div>
        </div>
        <?php } ?>
</div>
</div>
<br>
<br>
<!--/Engineering Service-->

<!--Coolfix-->



  
   <!--Contact Us Section-->
  <!--Footer Section-->
   <?php include('global-footer.php'); ?>

</body>
</html>