<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	
	<!-- NAV LEFT -->
	<ul class="navbar-nav">
		
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item">
			<a class="btn btn-danger nav-link text-white" href="#"><i class="fas fa-plus"></i> New</a>
		</li>


    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
	
		<?php if($_SESSION['sys_account_mode'] == 'employee') { ?>
		<!-- TIME IN -->
		<li class="nav-item d-none d-sm-inline-block ml-3">
			<?php
			if(isset($_SESSION['sys_time_in'])) {
				echo '<a href="#" class="btn btn-warning mr-2" data-toggle="modal" data-target="#modal-default-time-out"><i class="fa fa-clock mr-2"></i>'.renderLang($employees_time_out).'</a>';
				echo '<span>'.date('F j, Y - g:i:s a',$_SESSION['sys_time_in']).'</span>';
			} else {
				echo '<a href="#" class="btn btn-default" data-toggle="modal" data-target="#modal-default-time-in"><i class="fa fa-clock mr-2"></i>'.renderLang($employees_time_in).'</a>';
			}
			?>
		</li>
		<?php } ?>
		
	</ul><!-- nav left -->

	<!-- NAV RIGHT -->
	<ul class="navbar-nav ml-auto">
		
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#" title="<?php echo renderLang($switch_language); ?>">
				<i class="fa fa-globe-asia fa-lg"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right p-0">
				<?php
				foreach($language_arr as $language) {
					echo '<a href="/change-language/'.$language[0].'?url='.urlencode($actual_link).'" class="dropdown-item';
					if($language[0] == $_SESSION['sys_language']) {
						echo ' active';
					}
					echo '">'.$language[1].'</a>';
				}
				?>
			</div>
		</li>
        
		<!-- Notifications -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/common/notifications.php'); ?>
		
		<!-- Profile -->
		<li class="nav-item dropdown">
        	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="<?php echo $_SESSION['sys_photo']; ?>" class="brand-image w25 bg-dark" alt="User Image">
				<?php echo $_SESSION['sys_fullname']; ?> 
        	</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/settings" title="<?php echo renderLang($settings_title); ?>">
                    <i class="fa fa-cogs mr-2"></i> Settings
                </a>
                <a class="dropdown-item" href="/logout" title="<?php echo renderLang($login_logout); ?>">
                    <i class="fa fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </li>
		
	</ul><!-- nav right -->
	
</nav>

<!-- TIME IN -->
<div class="modal fade" id="modal-default-time-in">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo renderLang($time_confirm_time_in); ?></h4>
			</div>
			<div class="modal-body">
				<p class="text-center"><?php echo renderLang($time_please_confirm_time_in); ?></p>
				<a href="<?php echo '/time-in?url='.urlencode($actual_link); ?>" class="btn btn-primary btn-block btn-lg"><?php echo renderLang($time_time_in); ?></a>
				<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><?php echo renderLang($modal_close); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- TIME OUT -->
<div class="modal fade" id="modal-default-time-out">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><?php echo renderLang($time_confirm_time_out); ?></h4>
			</div>
			<div class="modal-body">
				<p class="text-center"><?php echo renderLang($time_please_confirm_time_out); ?></p>
				<a href="<?php echo '/time-out?url='.urlencode($actual_link); ?>" class="btn btn-warning btn-block btn-lg"><?php echo renderLang($time_time_out); ?></a>
				<button type="button" class="btn btn-default btn-block" data-dismiss="modal"><?php echo renderLang($modal_close); ?></button>
			</div>
		</div>
	</div>
</div>