<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="../Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Domine&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b52241fb5f.js"></script>
    </head>
<style type="text/css">
.temp{
  background-image: url('../Assets/Splash-Banner-Final.jpg');
  background-size:cover;
  background-position: fixed;
  background-repeat: no-repeat;
}


.text-l{
  text-align: left;
}
.br{
  display: none;
}
@media only screen and (max-width: 991px){
  .br{
    display: inline;
  }
  .text-l{
  text-align: center;
}
}
.br2{
  display: none;
}
@media only screen and (max-width: 1200px){
  .br2{
    display: inline;
  }
}

.vadadora{
  font-family: 'Hind Vadodara', sans-serif;
}
.font-size{
  font-size: 14px;
}

</style>

<body class="temp">
  <div class="container">
    <div class="row">

      <div class="col-md-5">
        <div class="mt-3 mb-5 text-white">
          <h3 style="font-family: 'Domine', serif;">Premier Property Services
            Company in the Phillipines</h3>
            <p class="vadadora font-size">Today, FPD Asia currently manages over 70 properties, spanning over 2.5 million square meters of gross floor area.</p>
        </div>
        <h5 class="text-white text-center font-weight-bold vadadora mt-5 pt-2">We are currently updating our website.</h5>
        <p class="text-white text-center vadadora font-size">For inquries or application please fill in the form below.</p>
        
        <form action="contactus-notif.php" method="post" class=" px-4">
          <div>
            <?php if (isset($_GET['success'])) {
            echo '<div class="alert alert-success row text-left">
          <strong >Thank You! <br>
          Your inquiry has been sent. <br>We will get back yo the soonest possible.</strong> .
          </div>';
            } ?>
          </div>
          <div class="form-group">
          <input class="form-control bg-light py-0 mt-2" type="text" name="contact_name" placeholder="Full Name"  style="font-size:14px;">
          </div>

          <div class="form-group">
          <input class="form-control bg-light  py-0 mt-2" type="email" name="contact_email" placeholder="Email" style="font-size:14px;">
          </div>

          <div class="form-group">
          <input class="form-control bg-light py-0 mt-2" type="text" name="contact_tel" placeholder="Phone Number" style="font-size:14px;">
            </div>

            <div class="form-group">
          <textarea type="text" name="contact_msg" class="form-control bg-light py-0 mt-2" rows="2" placeholder="Message"  style="font-size:14px;"></textarea>
            </div>

            <div class="form-group">
              <input type="submit" name="contact_submit" class="btn btn-danger form-control py-0 mt-2"  style="font-size:14px;">
            </div>
        </form>
            <div class="text-white" style="line-height: 15px; font-size: 12px;">We respect your privacy so as the information you provided. Rest assured that we will be treating this with the utmost confidentiality. </div>
        <div class="mt-3 text-l">
          <a href="http://124.105.153.234:83/" class="btn btn-danger px-5 py-1">Login</a>
        </div>
        
      </div>
      
        <br>
      
      <div class="col-md-7 mt-auto">
        <div class="text-white">
        <h3 class="font-weight-bold text-l mt-4">CONTACT US</h3>
        <p class=" text-white text-l">
          
           <i class='fas fa-map-marker-alt text-white'></i> &nbsp;The Penthouse 24H City Hotel <br class="br">
          P. Ocampo Sr. Extension corner  <br>
         <span class="ml-4"> Balagtas Street, Brgy La Paz, Makati City  </span>    
         
          <br>
        
          <i class='fas fa-mobile-alt text-white my-auto'></i> +63 2 8 815 3737 
           &nbsp;&nbsp;

          <i class='fas fa-fax text-white text-l my-auto'></i>&nbsp;+63 2 8 815 2195
            &nbsp; &nbsp; <br class="br2">
          <i class="fas fa-envelope text-white my-auto" ></i>&nbsp; <a href="mailto:inquiry@fpdasia.net" class=" text-white" style="padding: 0; margin: 0;">inquiry@fpdasia.net</a>
        
      </p>
          </div>
        
      </div>
      
    </div>
  </div>
  

  
</body>
</html>
