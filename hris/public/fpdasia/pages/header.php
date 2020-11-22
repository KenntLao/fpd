<?php 
 ?>

<nav class="nav_container navbar navbar-expand-lg">
	<div class="nav_item_container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fpdnavbar" aria-controls="fpdnavbar" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon fas fa-bars"></span>
		</button>
		<div class="collapse navbar-collapse" id="fpdnavbar">
			<ul class="navbar-nav text-uppercase">
				<li class="nav-item <?php echo $page == 'about' ? 'active' : '' ?>">
					<a href="about.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">about</a>
				</li>
				<!-- <li class="nav-item <?php echo $page == 'property management' ? 'active' : '' ?>">
					<a href="property-management.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">property management</a>
				</li> -->
				<li class="nav-item <?php echo $page == 'services' ? 'active' : '' ?>">
					<a href="services.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">services</a>
				</li>
				<li class="nav-item <?php echo $page == 'gallery' ? 'active' : '' ?>">
					<a href="gallery.php?albums" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">gallery</a>
				</li>
				<li class="nav-item <?php echo $page == 'news & events' ? 'active' : '' ?>">
					<a href="news-and-updates-view.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">news & events</a>
				</li>
				<li class="nav-item <?php echo $page == 'careers' ? 'active' : '' ?>">
					<a href="careers-application.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">careers</a>
				</li>
				<li class="nav-item" <?php echo $page == 'coolfix' ? 'active' : '' ?>>
					<a href="coolfix.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">coolfix</a>
				</li>
				<li class="nav-item <?php echo $page == 'contact us' ? 'active' : '' ?>">
					<a href="contactus.php" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">contact us</a>
				</li>
<li class="nav-item <?php echo $page == 'login' ? 'active' : '' ?>">
					<a href="http://124.105.153.234:83/" class="nav-link <?php echo $page == 'home' ? 'nav_link_mod' : '' ?>">Login</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div id="top_logo_container">
	<div id="top_logo_wrapper" class="ml-auto mr-auto rounded">
		<a href="index.php">
			<img class="top_logo ml-auto mr-auto" src="/Assets/header/FPD-Logo.png" alt="FPD Asia PROPERTY SERVICES, INC." width="100%">
		</a>
	</div>
</div>