<?php
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  
  <!-- NAV LEFT -->
  <ul class="navbar-nav">
    
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    
  </ul><!-- nav left -->

  <!-- NAV RIGHT -->
  <ul class="navbar-nav ml-auto">
    

    
    <!-- SETTINGS -->
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="fas fa-bell"></i>
      </a>
    </li>
    
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