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
    <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
<?php include('google-analytics.php') ?>
</head>
<style type="text/css">
  .roundeds{
    border-radius: 15px;
  }
  .gif{
    width: 14%;
  }

  @media only screen and (max-width: 991px){
    .gif{
      width: 20%;
    }
    .gif2{
      width: 95%;
    }
  }
  @media only screen and (max-width: 768px){
    .gif{
      width: 30%;
    }
    .sz{
      font-size:20px; 
    }
  }

  #more {display: none;}
  #more2 {display: none;}
  #more3 {display: none;}

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

 <div style="margin-top: 0%;">
  <div><img src="Assets/Services/Services-Banner.jpg" width="100%"></div>
</div>
<!-- CoolFix -->
<div class="container mt-5">
  <div class="row mb-3">
    <div class="m-auto">
      <img src="Assets/Services/engineer/Coolfix.png">
    </div>
  </div>
  <div class="row mb-4">
    <div class="text-center col-sm-12">
      <?php if (isset($_GET['success2'])) {
            echo '<div class="alert alert-success row "><strong class="text-center">
                   Thank You! Your Ask for details has been sent. We will get back you the soonest possible
                  </strong> .</div>';
                  } ?>
    </div><br>

    <?php

      $sql = "SELECT * FROM table_coolfix WHERE c_deleted IS NULL and c_id ORDER BY c_id ASC";

      $result = mysqli_query($con, $sql);

      while ($fetch = mysqli_fetch_array($result)) {
        $c_icon =$fetch['c_icon'];
        $c_name =$fetch['c_name'];
        $c_description =$fetch['c_description'];
        $c_id =$fetch['c_id'];
    ?>
      <div class="col-sm-12 col-md-6">
        <div class="p-3 my-2 bg-white roundeds height"> 
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-1">
              <div class=" row m-1">     
                <img src="Assets/Services/engineer/<?php echo $c_icon; ?>" class="m-auto">
              </div>
            </div>
            <h4 class="col-sm-12 col-md-12 col-lg-7 mb-0 text-ln my-auto">
              <?php echo $c_name; ?>
            </h4>
            <small class="col-sm-12 col-lg-4  text-r hide2 my-auto">
            <!-- Button trigger modal -->
              <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenterCoolfix<?php echo $c_id; ?>">Book now
              </button>
            </small>
            <div class="col-sm-12 px-4 pt-3 text-ln text-justify">
              <?php echo $c_description; ?>
            </div>
            <small class="hide m-auto">
              <button type="button" class="btn btn-outline-secondary rounded text-center" data-toggle="modal" data-target="#exampleModalCenterCoolfix<?php echo $c_id; ?>">Book now
              </button>
            </small>       
          </div>
        </div>
      </div>
    <?php } ?>
  </div>


    <?php
    $sql = "SELECT * FROM table_coolfix WHERE c_deleted IS NULL and c_id ORDER BY c_id ASC";
    $result = mysqli_query($con, $sql);
    while ($fetch = mysqli_fetch_array($result)) {
    $c_name =$fetch['c_name'];
    $c_id =$fetch['c_id'];
    ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterCoolfix<?php echo $c_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">
    <b>Book now:</b> <?php echo $c_name; ?>  
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <form method="post" action="coolfix-email-function.php">
    <div class="form-group display-none">
    <input type="text" name="details_es" value="<?php echo $es_name; ?>" class="form-control" >
    </div>
    <div class="form-group">
    <label for="recipient-name" class="col-form-label">Choose Date:</label>
    <input type="date" name="date_es" class="form-control" required>
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
    <div class="form-group">
    <label for="message-text" class="col-form-label">Message:</label>
    <textarea class="form-control" name="message_es" placeholder="Please describe the service you require..."></textarea>
    </div>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <input type="submit" name="submit" class="btn btn-success" value="Send">
    </div>
    </form>
    </div>
    </div>
    </div>
    <?php } ?>

</div>
<!-- /CollFix -->

   <!--Contact Us Section-->
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>
<script type="text/javascript">
  
  function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more&nbsp;<i class='fas fa-arrow-circle-right' style='font-size:20px'></i>";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "<i class='fas fa-arrow-circle-up' style='font-size:20px'></i>";
    moreText.style.display = "inline";
  }
}

function myFunction2() {
  var dots = document.getElementById("dots2");
  var moreText = document.getElementById("more2");
  var btnText = document.getElementById("myBtn2");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more&nbsp;<i class='fas fa-arrow-circle-right' style='font-size:20px'></i>";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "<i class='fas fa-arrow-circle-up' style='font-size:20px'></i>";
    moreText.style.display = "inline";
  }
}
function myFunction3() {
  var dots = document.getElementById("dots3");
  var moreText = document.getElementById("more3");
  var btnText = document.getElementById("myBtn3");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more&nbsp;<i class='fas fa-arrow-circle-right' style='font-size:20px'></i>";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "<i class='fas fa-arrow-circle-up' style='font-size:20px'></i>";
    moreText.style.display = "inline";
  }
}
</script>