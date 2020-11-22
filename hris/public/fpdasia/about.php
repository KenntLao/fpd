<!DOCTYPE html> 
<html lang="en">
<head>
  <link rel="shortcut icon" href="Gallery of Website/Logo/Company Logo.png"/>
  <title>FPD Asia Property Services, Inc.</title>
  <meta charset="utf-8">

<!--bootstrap-->
  <?php include('bootstrap/bootstrap.php'); ?>

    <link rel="stylesheet" type="text/css" href="fpdasia-css/index.css">
    <link rel="stylesheet" type="text/css" href="fpdasia-css/about.css">
    <link rel="stylesheet" type="text/css" href="/Assets/styles.css">
    <?php include('google-analytics.php') ?>

</head>
<body class="bg-light">
    <!--About page Section-->
  <?php include('navigation-bar.php') ?>

    <div >
      <img src="/banner/2.png" width="100%">
        <a name="history">
        </a>
    </div>

    <!--History-->
    <div class="container py-4"> 
      <div class="row">

        <div class="col-md-6">
          <h2 class=" m-2 font-weight-bold">
            <span data-aos="zoom-in" data-aos-duration="2000">
              <img src="gif/History.gif" class="gif-about" width="100%">
          </h2>
          <p class="text-justify">In 1990 we were first established by a Hong Kong-based group as First Pacific Davies Property Management, Inc., the first company to introduce the concept of professional property management in the Philippines. In 2000, the company merged with Savills, a UK-based property services group, and became FPDSavills. In 2005, the company became a wholly-owned Filipino company and became what it is known today – FPD Asia Property Services, Inc. Over a decade later, our success brought international interest and a partnership with Uniho of Japan.
          </p>
        </div>

        <div class="col-md-6">
          <div class="m-2">
            <img src="Assets/About/History.jpg" width="100%">
          </div>
        </div>

      </div>
      <!--visionmission-->
      <a name="visionmission"></a>
      <!--/visionmission-->

    </div>
    <!--End History-->
 
    <!--VISION & MISSION-->
    <div class="container pb-3 border-bottom cmt-5 cpt-5"> 
      <div class="row">

        <div class="col-lg-2 col-md-1 col-sm-12 "></div>

    <!--corpvalues-->
    <a name="corpvalues"></a>
    <!--/corpvalues-->

        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="row">
            <div class="row">

              <div class="col-lg-5 col-md-12 col-sm-12"> &nbsp;</div>

              <div class="col-lg-6 col-md-12 col-sm-12 ml-2 hide">
                <a onmouseenter="toggleShow('line-visions');" onmouseleave="toggleHide('line-visions');">
                  <img src="Assets/About/Our Vision.png" class="trio viss" onmouseenter="toggleShow('visions'),document.getElementById('gif-1').src='Assets/About/line-vision.gif';" onmouseleave="toggleHide('visions');">

                  <img src="Assets/About/line-vision.gif" class="line-vision" id="line-visions" style="display: none;">
                  <img id="gif-1" src="Assets/About/line-vision.gif" width="0%"/>
                </a>
              </div>

              <div class="col-lg-7 col-md-12 col-sm-12 mr-auto hide">
                <a onmouseenter="toggleShow('line-missions');" onmouseleave="toggleHide('line-missions');">
                  <img src="Assets/About/Our Mission.png" class="trio2 miss" onmouseenter="toggleShow('missions'),document.getElementById('gif-1').src='Assets/About/line-mission.gif';" onmouseleave="toggleHide('missions');">

                  <img src="Assets/About/line-mission.gif" class="line-mission" id="line-missions" style="display: none;">
                  <img id="gif-1" src="Assets/About/line-mission.gif" width="0%"/>
                </a>

              </div>

    <!--qualitypolicy-->
    <a name="qualitypolicy"></a>
    <!--/qualitypolicy-->

              <div class="col-lg-5 col-md-12 col-sm-12 hide">
                <a onmouseenter="toggleShow('line-corps');" onmouseleave="toggleHide('line-corps');">
                  <img src="Assets/About/Our Corporate.png" class="trio2 ml-2 corp" onmouseenter="toggleShow('corps'),document.getElementById('gif-1').src='Assets/About/line-corp.gif';" onmouseleave="toggleHide('corps');">
                  <img src="Assets/About/line-corp.gif" class="line-corps" id="line-corps" style="display: none;">
                  <img id="gif-1" src="Assets/About/line-corp.gif" width="0%"/>
                </a>
              </div>

            </div>
          <!--/row-->
          </div>
          <!--/row-->
            <div class="col-sm-12">
              <div class="row"> 
                <img src="Assets/About/What We Aim to Be.png" class="size mx-auto"  data-aos="zoom-in" onmouseenter="toggleShow('visions');" onmouseleave="toggleHide('visions');">
              </div>   
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-sm-12 my-auto">
          <div style="display:none;" id="visions" >
            <p class="text-justify ele">We are and shall remain premier property services company in the Philippines that provides customer-oriented, cost-effective, quality and excellent service in accordance with international standards to our clientele.</p>
          </div>

        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="row">
            <img src="Assets/About/Our Mission.png" width="30%" class="ml" onmouseenter="toggleShow('missions');" onmouseleave="toggleHide('missions');">
          </div>

            <div class="text-justify ele mission-margin" id="missions">
              <ul>
                <li> 
                Our task is to manage our clients’ assets & finances with the highest level of integrity and excellence;</li>
                <li> 
                Our employees must be highly competent, dependable, professional & with unquestioned integrity;
                </li>
                <li>
                We are to develop and maintain an efficient team of professionals whose quality workmanship adds value to the diverse portfolio of facilities we manage;
                </li>
                <li>
                We shall create a working environment that provides employees opportunities for growth;
                </li>
                <li>
                We must establish a strong position in the market, thereby ensuring maximum returns to our shareholders; and by God's will, with strong determination, we shall be good corporate citizens that contribute to the upliftment of the landscape of the property services industry in the country.
                </li>
              </ul>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="row">
            <img src="Assets/About/Our Corporate.png" width="30%" class="mr" onmouseenter="toggleShow('corps');" onmouseleave="toggleHide('corps');">
          </div>

            <div class="text-justify text-justify ele" style="display: none;"  id="corps" >

              <!--Corporate Values-->
              <div class="row text-uppercase mx-auto" >
      
    <!--corpvalues-->
    <a name="corpvalues"></a>
    <!--corpvalues-->

                <div class="col-lg-3 col-md-3 col-sm-3 text-center">
                  <img src="Assets/About/R.png" class="size-img pts-5" data-aos="fade-down" data-aos-duration="3000">
                    <h5 class="py-2 rfp" >Respect For People</h5>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3  text-center">
                  <img src="Assets/About/I.png" class="size-img pbs-5"  data-aos="fade-up" data-aos-duration="3000">
                    <h5 class="p-2" style="font-size:14px;">Integrity</h5>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3  text-center">
                  <img src="Assets/About/S.png" class="size-img pts-5" data-aos="fade-down" data-aos-duration="3000">
                    <h5 class="p-2" style="font-size:14px;">Stewardship</h5>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-3  text-center">
                  <img src="Assets/About/E.png" class="size-img pbs-5" data-aos="fade-up" data-aos-duration="3000">
                    <h5 class="p-2" style="font-size:14px;">Excellence</h5>
                </div>
                                
              </div>
            </div>


        </div>
      </div>
    </div>
<!--End VISION & MISSION-->

<div class="container">
  <div class="row">
    <!--Quality Policy-->
    <div class="col-sm-12 col-md-7 py-3"> 
      <h2 class="text-uppercase  font-weight-bold">
           <img src="gif/Health-&-Safety.gif" class="gif-about" width="80%">
      </h2> 
        <p class="text-justify">In fulfillment of the vision to be the premier property services company in the Philippines, we are committed to provide client satisfaction while promoting a green environment in a healthy and injury-free workplace. Thus, we shall be:<br></p>
          <div style="font-size: 15.9px;">

            <div class="bg-white shadow my-2 p-3 pb-0 text-justify rounded">
              <span class="qlty-p ">F</span>
              <span>  
              ocused in fulfilling the present and future needs of our clients;
              </span>
            </div>

            <div class="bg-white shadow my-2 p-3 pb-0 text-justify rounded">
              <span class="qlty-p">P</span>
              <span class="">    
              ersistent in promoting the establishment and maintenance of QEHS systems.; and
              </span> 
            </div>

            <div class="bg-white shadow my-2 p-3 pb-0 text-justify rounded"> 
              <span class="qlty-p">D</span> 
              <span class="">   
              iligent in engendeing this policy among our employees.
              </span> 
            </div>
          </div>
    </div>
    <!--Corporate Values-->
    <a name="certification"></a>
    <div class="col-sm-12 col-md-5"> 
      <!--Certicate Section-->
      <div class="container py-3 ">
        <h2 class="text-left font-weight-bold my-4">Certifications</h2>
          <p class="text-justify">In accordance with our ISO 9001:2015 and 14001:2015 certifications, we adhere to Quality, Environmental, Health and Safety Policy —
          </p>

          <div class="container">
            <div class="row">
              <!--first certicate-->
              <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
                <div class="ml-3">
                  <a data-fancybox="gallery" href="Assets/ISO 9001 2015 Certificate.jpg">
                    <img src="Assets/ISO 9001 2015 Certificate.jpg" width="100%">
                      <p class="text-secondary text-l">ISO 9001:2015 <br>
                      Quality Management System
                      </p>
                  </a>
                </div>
              </div>
              <!--end first certicate-->

              <!--second certicate-->
              <div class="col-lg-6 col-md-12 col-sm-12 mx-auto">
                <div class="ml-3">
                  <a data-fancybox="gallery" href="Assets/ISO 14001 2015 Certificate.jpg">
                    <img src="Assets/ISO 14001 2015 Certificate.jpg" width="100%">
                      <p class="text-secondary text-l">ISO 14001:2015 <br>
                      Environment Management  System
                      </p>
                  </a>
                </div>
              </div>
              <!--end second certicate-->
            </div>
          </div>
      </div>
      <!--/Certicate Section-->                            
    </div>

  </div>
</div>

<div class="container pb-5">
  <a name="partners">
    <h2 class="font-weight-bold text-center"  data-aos="zoom-in" data-aos-duration="2000">
      <img src="Assets/About/Our-Partners.gif" class="gif-about" width="25%">
    </h2>
  </a>
  <div class="row">
  
    <div class="col-sm-12 col-md-6 my-auto text-justify">
      <p>In 2018, we became affiliated with Zen Holdings Ltd. of Japan. The multiple business ventures of the Zen Group include merchant development, construction and property management</p>
    </div>

    <div class="col-sm-12 col-md-6 ">
      <span class="row">
        <img src="Assets/Home/Partners-1.png" class="m-auto" width="35%">
        <img src="Assets/Home/Partners-2.png" class="m-auto"  width="35%">
      </span>
    </div>

  </div>
</div>
     
<!--Footer Section-->
  <div class="footer-container">
   <?php include('pages/footer.php'); ?>
  </div>

</body>
<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v8.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution=setup_tool
        page_id="447280295316160"
  theme_color="#fa3c4c"
  logged_in_greeting="Thanks for dropping by. How may I assist you today?"
  logged_out_greeting="Thanks for dropping by. How may I assist you today?">
      </div>
</html>
<script>
function toggleShow(elementId) {
  let el = document.getElementById(elementId);
  el.style.display = "block";
}

function toggleHide(elementId) {
  let el = document.getElementById(elementId);
  el.style.display = "none";
}


  AOS.init();
</script>
    <script type="text/javascript">
         var screen_width = window.outerWidth;
  var screen_height = window.outerHeight;

  var scroll_top = window.onscroll = function() {
    scroll_top = window.pageYOffset;
  };

$(window).on('scroll load', function () {
    animateNavbar();

   
  });

  function animateNavbar() {
  if (screen_width >= 991 ) {
    if (scroll_top > 0) {
      $('.navbar').addClass('bg-white active');
      $('.navbar-brand ').css({
        'height': '75px',
        'transition': '.5s'
      });
      $('.logo-css').css({
        'width': '60px',
        'transition': '.6s'
      });
    }
   else {
      $('.navbar').addClass('bg-white active');
      $('.navbar-brand ').css({
        'height': '115px',
        'transition': '.5s'
      });
      $('.logo-css').css({
        'width': '98px',
        'transition': '.6s'
      });
    }
  }
}
    </script>