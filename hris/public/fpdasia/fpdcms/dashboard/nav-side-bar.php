<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <!-- if Marketing is role -->
      <?php 
      if ($_COOKIE['role']=='Marketing') {
      ?>
      
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="services-engineering.php" class="nav-link">
                  <i class="fas fa-hard-hat nav-icon"></i>
                  <p>Engineering Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="services-coolfix.php" class="nav-link">
                  <i class="fas fa-tools nav-icon"></i>
                  <p>Coolfix</p>
                </a>
              </li>
            </ul>
          </li>

      <?php }?>
      <!-- if HR is role -->
      <?php 
      if ($_COOKIE['role']=='HR') {
      ?>
      
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon ion ion-folder"></i>
              <p>
                Careers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/forms/general.html" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Positions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/advanced.html" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Applicants</p>
                </a>
              </li>
            </ul>
          </li>

      <?php }?>
      <!-- if super admin is role -->
      <?php 
        if ($_COOKIE['role']=='Admin') { ?>
          <li class="nav-item ">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="home.php" class="nav-link">
              <i class="nav-icon ion ion-image"></i>
              <p>
                Home
                <span class="right badge badge-danger">slider</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Services
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="services-engineering.php" class="nav-link">
                  <i class="fas fa-hard-hat nav-icon"></i>
                  <p>Engineering Services</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="services-coolfix.php" class="nav-link">
                  <i class="fas fa-tools nav-icon"></i>
                  <p>Coolfix</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="property.php" class="nav-link">
              <i class="nav-icon far fa-building"></i>
              <p>
                Properties
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-images"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-newspaper"></i>
              <p>
                News and Updates
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon ion ion-folder"></i>
              <p>
                Careers
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/forms/general.html" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Positions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/forms/advanced.html" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Applicants</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon ion ion-person"></i>
              <p>
                Add Admin
              </p>
            </a>
          </li>
          <?php } else{ echo ""; } ?>           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->