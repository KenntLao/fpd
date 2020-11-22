<?php 

	require ("./functions/edit-home-assets.php");
	require ("./cms/config.php");

	function fetchFromDatabase($asset_name) {
		$sql = "
			SELECT 
				name, 
				content 
			FROM 
				table_homepage 
			WHERE 
				name = '$asset_name'
			";
		$result = mysqli_query($GLOBALS['con'], $sql);
		$data = mysqli_fetch_assoc($result);
		return $data['content'];
	}

	$main_company_description = fetchFromDatabase("main_company_description");
	$short_company_description = fetchFromDatabase("short_company_description");
	$homepage_banner = fetchFromDatabase("homepage_banner");
	$homepage_vertical_banner = fetchFromDatabase("homepage_vertical_banner");
	$consulting_description = fetchFromDatabase("consulting_description");
	$audit_description = fetchFromDatabase("audit_description");
	$real_estate_management_description = fetchFromDatabase("real_estate_management_description");
	$engineering_description = fetchFromDatabase("engineering_description");
	$secondary_banner = fetchFromDatabase("secondary_banner");
	$service_excellence_description = fetchFromDatabase("service_excellence_description");

?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>FPD Asia</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="/Assets/header/FPD-Logo.png"/>
 	<?php 

 		require ($_SERVER['DOCUMENT_ROOT'] . "/includes/links.php") 

	 ?>
<?php include('google-analytics.php') ?>
 </head>
 <body>
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
	<?php 

		require ($_SERVER['DOCUMENT_ROOT'] . "/pages/header.php");

	 ?>
	<!-- banner area -->
	<div class="banner_container">
		<!-- banner image -->
		<div class="banner_image_container w-100">
			<div class="banner_overlay w-100 h-100"></div>
			<img class="main_home_banner" src="/Assets/Home/banner/<?=$homepage_banner ?>" width="100%">
		</div>
		<!-- banner image -->

		<!-- company description in banner -->
		<div class="banner_company_desc text-center">
			<div class="main_company_desc">
				<?= $main_company_description ?>
			</div>
			<div class="short_company_desc mt-2">
				<?= $short_company_description ?>
			</div>
		</div>
		<!-- company description in banner -->

		<!-- inquiry form in banner -->
		<div class="banner_quick_inquiry_form p-4 w-75 ml-auto mr-auto mt-4 rounded">
			<form action="./functions/send-email-home.php" method="POST">
				<div class="row pr-3 pl-4 pt-1">
					<div class="col-sm-3 p-0 pr-2 mb-1">
						<input class="form-control" type="text" name="name" placeholder="Name">
					</div>
					<div class="col-sm-3 p-0 pr-2 mb-1">
						<input class="form-control" type="email" name="email" placeholder="Email">
					</div>
					<div class="col-sm-3 p-0 pr-2 mb-1">
						<input class="form-control" type="text" name="phone_number" placeholder="Phone">
					</div>
					<div class="col-sm-3 p-0 pr-2">
						<input class="btn btn-danger form-control" type="submit" name="submit" value="Send">
					</div>
				</div>
			</form>
		</div>
		<!-- inquiry form in banner -->

		<!-- scroll down button in the banner -->
		<div class="banner_scroll_btn_container text-center">
			<button class="btn btn-outline-light rounded-circle scroll_down_btn"><span class="fas fa-chevron-down"></span></button>
		</div>
		<!-- scroll down button in the banner -->

		<!-- v-divider -->
		<div class="banner_vdivider_container">
			<img src="/Assets/Home/banner/V-divider.png" width="100%">
		</div>
		<!-- v-divider -->
	</div>
	<!-- banner area -->

	<!-- content area -->
	<div>
		<!-- What we do Title -->
		<div class="container">
			<p class="text-uppercase text-center">what we do</p>
			<div class="row property_care_container">
				<div class="col-6 p-0 text-right property_label">
					<label class="text-uppercase p-0">property</label>
				</div>
				<div class="col-6 p-0 pt-2">
					<div class="care_container">
						<img src="/Assets/Home/what-we-do/CARE.png" width="100%">
					</div>
				</div>
			</div>
		</div>
		<!-- What we do Title -->

		<!-- What we do categories -->
		<div class="row categories_container">
			<div class="col-12 col-md-3 category_card" id="consulting_card">
				<div class="category_icon_container">
					<img class="category_icon_img" src="/Assets/Home/what-we-do/Consulting.png" width="100%">
				</div>
				<p class="font-weight-bold mt-3 mb-4 category_title text-center">Consulting</p>
				<p class="text-justify"><?= $consulting_description ?></p>
				<div class="mt-4">
					<a class="learn_more_btn text-uppercase" href="">
						Learn More
						<i class="fas fa-chevron-right learn_more_circle"></i>
					</a>
				</div>
			</div>
			<div class="col-12 col-md-3 category_card" id="audit_card">
				<div class="category_icon_container">
					<img class="category_icon_img" src="/Assets/Home/what-we-do/Audit.png" width="100%">
				</div>
				<p class="font-weight-bold mt-3 mb-4 category_title text-center">Audit</p>
				<p class="text-justify"><?= $audit_description ?></p>
				<div class="mt-4">
					<a class="learn_more_btn text-uppercase" href="">
						Learn More
						<i class="fas fa-chevron-right learn_more_circle"></i>
					</a>
				</div>
			</div>
			<div class="col-12 col-md-3 category_card" id="real_estate_card">
				<div class="category_icon_container">
					<img class="category_icon_img" src="/Assets/Home/what-we-do/Real-Estate.png" width="100%">
				</div>
				<p class="font-weight-bold mt-3 mb-4 category_title text-center">Real Estate Management</p>
				<p class="text-justify"><?= $real_estate_management_description ?></p>
				<div class="mt-4">
					<a class="learn_more_btn text-uppercase" href="">
						Learn More
						<i class="fas fa-chevron-right learn_more_circle"></i>
					</a>
				</div>
			</div>
			<div class="col-12 col-md-3 category_card" id="engineering_card">
				<div class="category_icon_container">
					<img class="category_icon_img" src="/Assets/Home/what-we-do/Engineering.png" width="100%">
				</div>
				<p class="font-weight-bold mt-3 mb-4 category_title text-center">Engineering</p>
				<p class="text-justify"><?= $engineering_description ?></p>
				<div class="mt-4">
					<a class="learn_more_btn text-uppercase" href="services-engineer.php">
						Learn More
						<i class="fas fa-chevron-right learn_more_circle"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- What we do categories -->
	</div>
	<br>
	<div>
		<div class="our_commitment_container row">
			<div class="col-md-1">
				<div class="our_commitment text-uppercase">
					<label>our commitment</label>
				</div>
			</div>
			<div class="col-md-11 our_commitment_img">
				<img src="/Assets/Home/banner/<?= $secondary_banner ?>" width="100%">
			</div>
		</div>
		<div class="service_excellence_container">
			<div class="service_excellence_gif">
				<img src="/Assets/Home/service-excellence.gif" width="100%">
			</div>
			<div>
				<p class="service_excellence_content text-justify"><?= $service_excellence_description ?></p>
			</div>
			<div>
				<a class="services_learn_more text-uppercase" href="">
					Learn More
				</a>
			</div>
		</div>
	</div>
	
	<!-- content area -->

	<?php 

		require ($_SERVER['DOCUMENT_ROOT'] . "/pages/footer.php");

	 ?>


	<script type="text/javascript" src="/functions/common.js"></script>
	<script type="text/javascript">
		var vertical_img = "<?php echo '/Assets/Home/banner/' . $homepage_vertical_banner ?>";
		var regular_img = "<?php echo '/Assets/Home/banner/' . $homepage_banner ?>";

		var consulting_hover_icon = "<?php echo '/Assets/Home/what-we-do/hovers/Consulting.png' ?>";
		var consulting_icon = "<?php echo '/Assets/Home/what-we-do/Consulting.png' ?>";

		var audit_hover_icon = "<?php echo '/Assets/Home/what-we-do/hovers/Audit.png' ?>";
		var audit_icon = "<?php echo '/Assets/Home/what-we-do/Audit.png' ?>";

		var real_estate_hover_icon = "<?php echo '/Assets/Home/what-we-do/hovers/Real-Estate.png' ?>";
		var real_estate_icon = "<?php echo '/Assets/Home/what-we-do/Real-Estate.png' ?>";

		var engineering_hover_icon = "<?php echo '/Assets/Home/what-we-do/hovers/Engineering.png' ?>";
		var engineering_icon = "<?php echo '/Assets/Home/what-we-do/Engineering.png' ?>";


		$(document).ready(function() {
			
			change_img_on_mouse_event(consulting_hover_icon, consulting_icon, "#consulting_card");
			change_img_on_mouse_event(audit_hover_icon, audit_icon, "#audit_card");
			change_img_on_mouse_event(real_estate_hover_icon, real_estate_icon, "#real_estate_card");
			change_img_on_mouse_event(engineering_hover_icon, engineering_icon, "#engineering_card");

		});
	</script>
 </body>
 </html>