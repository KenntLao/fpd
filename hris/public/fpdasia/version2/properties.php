<?php  
      include __DIR__."/../cms/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="../Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Proxima+Nova">
  

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b52241fb5f.js"></script>

    <link rel="stylesheet" type="text/css" href="../fpdasia-css/index.css">

      <!-- 1. Add latest jQuery and fancybox files -->

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js">
  <link rel="stylesheet" type="text/css" href="../fpdasia-css/index.css"></script>
</head>
<style type="text/css">
.roundeds{
  border-radius: 15px;
}
@media only screen and (max-width: 991px){
    .dropdown-menu{
  right:0;
  float: right;
  text-align: right;
  }
  }
  .bg-col{
    background-color: white;
  }
  .bg-col:hover, .bg-col:focus{
    background-color: #ff1a1a;
    color: white;
    border: 2px solid white;
  }
</style>
<body class="bg-light">
 		 <nav class="navbar fixed-top navbar-expand-lg bg-white text-uppercase">
        
        <a class="navbar-brand" href="index.php">
          <img src="../Gallery of Website/Logo/Company Logo.png" width="90px" class="logo-css">
        </a>

         <button style="outline: none;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
           <span class="fas fa-bars nav-icon pr-3" ></span>
         </button>

     <div class=" collapse navbar-collapse" id="navbarNav" style="position: right">
      <div class="row ml-auto">
      <ul class=" nav font-size col-lg-3 ml-auto" style="font-size: 15px;">
        <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a class=" hover-text-gray nav-link" href="../contactus.php">Contact</a>
          </div>
        </li>
        <li class="nav-item nav-item-resp nav-none">
          <div>
          <a class=" nav-link"><span class="text-dark"> | </span></a>
        </div>
        </li>
        <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a href="http://124.105.153.234:83/" class="hover-text-gray nav-link">Login</a>
        </div>
        </li>
      </ul>
       <ul class=" nav font-size col-lg-12">
        <li class="nav-item  nav-item-resp ml-auto">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="index.php">Home</a>
          </div>
        </li>
        <li class="nav-item nav-item-resp dropdown">
          <div class="hov">
          <a class="nav-link  hover-text-color " href="about.php" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>

          <div class=" dropdown-menu" aria-labelledby="nav-item">
            <div class="hov2">
              <a class="dropdown-item" href="about.php#history">History</a>
            </div>
            <div class="hov2">
              <a class="dropdown-item" href="about.php#vissionmission">Vision & Mission</a>
            </div>
            <div class="hov2">
              <a class="dropdown-item" href="about.php#qualitypolicy">Quality Policy</a>
            </div>
            <div class="hov2">
              <a class="dropdown-item" href="about.php#corpvalues">Corporate Values</a>
            </div>
            <div class="hov2">
              <a class="dropdown-item" href="about.php#certification">Certification</a>
            </div>
            <div class="hov2">
              <a class="dropdown-item" href="about.php#partners">Our Partners</a>
            </div>
          </div>
          </div>
          
        </li>
        <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="services.php">Services</a>
          </div>
        </li>
        <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="property-management.php">Properties</a>
          </div>
        </li>
        <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="../gallery.php?albums">Gallery</a>
          </div>
        </li>
          <li class="nav-item nav-item-resp ">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="../news-and-updates-view.php">News & Updates</a>
          </div>
        </li>

        <li class="nav-item nav-item-resp">
          <div class="hov">
          <a class=" hover-text-color nav-link" href="../careers-application.php">Careers</a>
          </div>
        </li>
        <li class="mx-3">
        </li>
        
        
       </ul>
       </div>
      </div>
    </nav>

  <div>
    <img src="../Assets/Projects/About-Banner.jpg" width="100%">
  </div>


  <div class="container mb-5">
    <h2 class="font-weight-bold text-center mt-2">
  <span><img src="../gif/Management.gif" class="gif2" ></span>
</h2>

      <p class="text-center text-secondary mrl text-justify">
     FPD Asia currently manages over 70 properties, spanning over 2.5 million square meters of gross floor area. Its managed portfolio consists of the following types of properties:
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
        <div class="col-md-4 my-auto">
          <div class=" text-center bg-white roundeds p-5 my-2 shadow">  
            <a href="../property-management-view.php?pm_id=<?php echo $pm_id; ?>" 
                class="text-danger" style="text-decoration: none;">
          <img src="Assets/Projects/<?php echo $pm_icon; ?>" class="mb-3"><br>

          <h3 class="font-weight-bold">
            <?php echo $pm_name; ?>
          </h3>
            </a>
          </div>
        </div>
        <?php }?>

    </div> 
      </div><br>



<!--Footer Section-->
   <style type="text/css">
    .text-l{
    text-align:left;
  }
  @media only screen and (max-width: 991px){
    .text-l{
    text-align:center;
  }
  }
  .none{
    display: inline;
  }
  @media only screen and (max-width: 1200px){
    .none{
    display: none;
  }
  }
</style>
<!--Contact Us Section-->

  <div class="container-contact bg-white" style="margin: 0;">
    <div class="container">
    <div class="form-row  pt-3">

      <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-l">
        <img src="../Gallery of Website/Logo/Company Logo.png" width="100px" class="bg-white m-0">
    
      </div><div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-l" 
      style="font-size:14px;">
        <p class="mt-3">
          <a class="text-dark" href="property-management.php">Properties</a><br>
          <a class="text-dark" href="">Project Management</a><br>
          <a class="text-dark" href="property-management-view.php?pm_id=3">Facilities Management</a>
        </p>
    
      </div>

      <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-l" style="font-size:15px;">
       <p class="mt-3">
          <a class="text-dark" href="services.php"> Consultancy</a><br>
          <a class="text-dark" href="services-engineer.php#coolfix">Technical Services</a><br>
          <a class="text-dark" href="services-engineer.php">Engineering Services</a>
        </p>
          
      </div>

    <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 text-l" style="font-size:15px;">
       <p class="mt-3">
          <a class="text-dark" href="about.php">About FPD</a><br>
          <a class="text-dark" href="../careers-application.php">Careers</a><br>
          <a class="text-dark" href="../news-and-updates-view.php">News & Update</a>
        </p>
          
      </div>



      <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-1 text-l ">
        
       <p class=" text-l text-dark" style="font-size: 14px;">
          <i class='fas fa-map-marker-alt text-danger'></i>&nbsp;&nbsp;
          The Penthouse 24H City Hotel 
          <span class="none"><br> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</span>P. Ocampo Sr. Extension corner 
          <span class="none"><br> &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</span>Balagtas Street, Brgy La Paz, Makati City
            <br>
            
          
          <i class='fas fa-mobile-alt text-danger'></i>&nbsp;&nbsp; +63 2 8 815 3737 
           &nbsp;&nbsp;

          <i class='fas fa-fax text-danger text-l'></i>&nbsp;&nbsp;+63 2 8 815 2195
            &nbsp; &nbsp; <br>
            
          <i class="fas fa-envelope text-danger text-l my-auto" ></i>&nbsp;&nbsp;<a href="mailto:inquiry@fpdasia.net" class=" text-dark" style="padding: 0; margin: 0;">inquiry@fpdasia.net</a><br>

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
    <a class="text-reset" href="../terms-and-conditions.php">Terms</a>  and   
    <a class="text-reset" href="../privacy-and-policy.php">Privacy Policy</a>&nbsp; &nbsp;&nbsp;|&nbsp; &nbsp; 
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
</div>

</body>
</html>