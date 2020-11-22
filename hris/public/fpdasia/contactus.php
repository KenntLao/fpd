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
    .text-l{
    text-align:left;
  }
  @media only screen and (max-width: 991px){
    .text-l{
    text-align:center;
  }
  }
.container-contact2{
  width: 70%;
  margin: auto;
  text-align: center;
  margin-top: -110px;
}
</style>
<body class="bg-light">
      <!--About page Section-->
  <?php include('navigation-bar.php') ?>

  <div class="map-container">
 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.786015686974!2d121.0042590579138!3d14.566449193451694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c99e0f0123f7%3A0x1c82449f2d5917ff!2s9824%20Kamagong%2C%20Makati%2C%20Kalakhang%20Maynila!5e0!3m2!1sen!2sph!4v1595567116401!5m2!1sen!2sph" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
<!--Google Maps-->

  </div><br><br><br><br><br>

   <!--Contact Us Section-->
  <div class="container-contact2">
    <div style="width: 25%; margin: 0 auto 0 auto">
      <img src="gif/Contact-Us.gif" width="100%" >
    </div>
    <p><h4>We look forward to hearing from you!</h4>
      For any inquiry, please fill out the inquiry form or you may call us.</p><br><br>
    <div class="form-row">

      <div class="col-md-6 col-sm-12 text-l">
        <h3>GET IN TOUCH</h3>
        <p class="text-secondary text-l"><i class="fas fa-map-marker-alt fa-fw mr-2"></i>9824 Kamagong Street <br>
          <span class="ml-4">San Antonio Village</span> <br>
          <span class="ml-4">Makati City, 1203 Philippines</span>
          <br><br>
          <i class="fas fa-phone-alt fa-fw mr-2"></i>Trunkline : +63 2 5304 9191  <br>
          <i class="fas fa-fax fa-fw mr-2"></i>Fax : +63 2  5304 9192 <br>
          <i class="fas fa-envelope fa-fw mr-2"></i>Email Address : <a href="mailto:inquiry@fpdasia.net" class=" text-secondary" style="padding: 0; margin: 0;">inquiry@fpdasia.net</a></p>
      </div><br>




      <div class="col-md-6 col-sm-12">
        <h3 class="text-uppercase">inquiry form</h3>
        <p class="text-secondary">We respect your privacy so as your the information you provide. Rest assured that we will be treating this with the utmost confidentiality.</p>
        <form action="contactus-notif.php" method="post">
          <div>
            <?php if (isset($_GET['success'])) {
    echo '<div class="alert alert-success row text-left">
          <strong >Thank You! <br>
Your inquiry has been sent. <br>We will get back you the soonest possible.</strong> .
          </div>';
  } ?>
          </div>
          <div class="form-group">
          <input class="form-control" type="text" name="contact_name" placeholder="Full Name">
          </div>

          <div class="form-group">
          <input class="form-control" type="email" name="contact_email" placeholder="Email">
          </div>

          <div class="form-group">
          <input class="form-control" type="text" name="contact_tel" placeholder="Phone Number">
            </div>

            <div class="form-group">
          <textarea type="text" name="contact_msg" class="form-control" rows="3" placeholder="Message"></textarea>
            </div>

            <div class="form-group">
              <input type="submit" name="contact_submit" class="btn btn-danger form-control">
            </div>
        </form>
      </div>
      
    </div>
  </div><br>

  <!-- <div class="container-contact bg-white" style="margin: 0;">
    <div class="container">
    <div class="form-row  pt-3">

      <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-l">
        <img src="Gallery of Website/Logo/Company Logo.png" width="100px" class="bg-white m-0">
    
      </div><div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 text-l" 
      style="font-size:14px;">
        <p class="mt-3">
          <a class="text-dark hov" href=""> Property Management</a><br>
          <a class="text-dark" href="">Project Management</a><br>
          <a class="text-dark" href="">Facilities Management</a>
        </p>
    
      </div>

      <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 text-l" style="font-size:15px;">
       <p class="mt-3">
          <a class="text-dark" href=""> Consultancy</a><br>
          <a class="text-dark" href="services-engineer.php#coolfix">Technical Services</a><br>
          <a class="text-dark" href="services-engineer.php">Engineering Services</a>
        </p>
          
      </div>

    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12 text-l" style="font-size:15px;">
       <p class="mt-3">
          <a class="text-dark" href="about.php"> About FPD</a><br>
          <a class="text-dark" href="careers-application.php">Careers</a><br>
          <a class="text-dark" href="news-and-updates-view.php">News & Update</a>
        </p>
          
      </div>
      </div>
      </div>
      </div>
      
    
<div class="bg-danger text-white">
  <div class="container py-2 small text-center  text-justify">
<div class="row">
    <div class=" col-lg-6 text-lg-left">
    &copy; 2019 FPD Asia Property Services, Inc. All Rights Reserved. &nbsp; &nbsp; 
    </div>
    <div class="col-lg-6 text-lg-right">  
    <a class="text-reset" href="terms-and-conditions.php">Terms</a>  &   
    <a class="text-reset" href="privacy-and-policy.php">Privacy Policy</a>&nbsp; &nbsp;&nbsp;|&nbsp; &nbsp; 
    Site Design by <a href="//socialconz.com" class="text-reset" target="_blank">SocialConz Digital</a>&nbsp; &nbsp; &nbsp; &nbsp; 
    <a href="" class="fab fa-facebook " 
        style="font-size: 15px; text-decoration: none;"></a>

        <a href="https://www.youtube.com/channel/UCmK8b1E6D8DNCaCFgz1Bo_A" target="_blank" 
        class="fab fa-youtube " style="font-size: 15px; text-decoration: none;"></a>

        <a href="https://twitter.com/FPDAsia" target="_blank" class="fab fa-twitter" 
        style="font-size: 15px; text-decoration: none;"></a>

        <a href="https://www.linkedin.com/company/fpd-asia-property-services-inc-/" 
        target="_blank" class="fab fa-linkedin " 
        style="font-size: 15px; text-decoration: none;"></a>
    </div>
</div>
  </div>
</div> -->

<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
</html>

