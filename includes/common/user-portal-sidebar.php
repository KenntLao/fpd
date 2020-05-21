<aside class="main-sidebar sidebar-dark-white elevation-4 pms-red">
  
    <!-- LOGO -->
    <a href="/dashboard" class=" border-0">
        <div class="container-fluid mb-1">
            <div class="row">
                <img src="/assets/images/image001.jpg" alt="Raianseier" class="mt-2 brand-image w30p elevation-3 mx-auto">
            </div>
        </div>
    </a>

    <!-- SIDEBAR -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        

               
                <!-- DASHBOARD -->
                <li class="nav-item ">
                    <a href="/user-portal" class="nav-link<?php if($page == 'user-portal') { echo ' active'; } ?>">
                        <i class="nav-icon fas fa-list-ul"></i>
                        <p><?php echo renderLang($dashboard_dashboard); ?></p>
                    </a>
                </li>

                <!-- My Account -->
                <li class="nav-header font-weight-bold">My Account</li>

                <!-- MY UNIT -->
                <li class="nav-item">
                    <a href="/user-units" class="nav-link<?php echo $page == 'my-units' ? ' active' : '' ?>">
                        <i class="fas fa-building nav-icon"></i>
                        <p><?php echo renderLang($user_portal_my_units); ?></p>
                    </a>
                </li>

                <!-- MY TRANSACTION -->
                <li class="nav-item">
                    <a href="" class="nav-link<?php echo $page == 'my-transactions' ? ' active' : '' ?>">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <p>My Transactions</p>
                    </a>
                </li>

                <!-- HELP DESK -->
                <li class="nav-header font-weight-bold">Customer Service</li>

                <!-- USER SERICE REQUEST -->
                <li class="nav-item">
                    <a href="/user-service-requests" class="nav-link<?php echo $page == 'user-service-requests' ? ' active' : '' ?>">
                        <i class="fas fa-exclamation-circle nav-icon"></i>
                        <p><?php echo renderLang($service_request); ?></p>
                    </a>
                </li>

                <!-- GATE PASS --> 
                <li class="nav-item has-treeview <?php echo $page == 'user-visitors' || $page == 'user-move-inout-requests' || $page == 'user-service-providers' || $page == 'user-gate-pass-employee' ? 'menu-open' : ''; ?>"> 
                    <a href="#" class="nav-link"> 
                        <i class="nav-icon fas fa-ticket-alt"></i> 
                        <p> 
                            <?php echo renderLang($gate_pass); ?> 
                            <i class="fas fa-angle-left right"></i> 
                        </p> 
                    </a> 
                    <ul class="nav nav-treeview pl-3"> 
                        
                    <!-- VISITORS -->
                        <li class="nav-item"> 
                            <a href="/user-visitors" class="nav-link <?php echo $page == 'user-visitors' ? ' active' : '' ?>"> 
                                <p><?php echo renderLang($visitors); ?></p> 
                            </a> 
                        </li> 
                        
                        <!-- MOVE IN/OUT REQUESTS -->
                        <li class="nav-item"> 
                            <a href="/user-move-inout-requests" class="nav-link <?php echo $page == 'user-move-inout-requests' ? ' active' : '' ?>"> 
                                <p><?php echo renderLang($move_inout_requests); ?></p> 
                            </a> 
                        </li>
 
                        <!-- SERVICE PROVIDERS 
                        <li class="nav-item"> 
                            <a href="" class="nav-link <?php //echo $page == 'service-providers' ? ' active' : '' ?>"> 
                                <p><?php //echo renderLang($service_providers); ?></p> 
                            </a> 
                        </li> -->

                        <!-- GATE PASS EMPLOYEES 
                        <li class="nav-item"> 
                            <a href="" class="nav-link <?php //echo $page == 'gate-pass-employee' ? ' active' : '' ?>"> 
                                <p><?php //echo renderLang($gate_pass_employees); ?></p> 
                            </a> 
                        </li>-->
                    </ul> 
                </li>

                <!-- RESERVATION -->
                <li class="nav-item has-treeview <?php echo $page == 'user-boardrooms' || $page == 'user-amenities' ? 'menu-open' : ''; ?>"> 
                    <a href="#" class="nav-link"> 
                        <i class="nav-icon far fa-calendar-minus"></i> 
                        <p> 
                            <?php echo renderLang($reservation); ?> 
                            <i class="fas fa-angle-left right"></i> 
                        </p> 
                    </a> 
                    <ul class="nav nav-treeview pl-3">

                        <!-- BOARDROOM -->
                        <li class="nav-item"> 
                            <a href="/user-boardrooms" class="nav-link <?php echo $page == 'user-boardrooms' ? ' active' : '' ?>"> 
                                <p><?php echo renderLang($boardrooms); ?></p> 
                            </a> 
                        </li>

                        <!-- AMENITIES -->
                        <li class="nav-item"> 
                            <a href="/user-amenities" class="nav-link <?php echo $page == 'user-amenities' ? ' active' : '' ?>"> 
                                <p><?php echo renderLang($amenities); ?></p> 
                            </a> 
                        </li> 
                    </ul> 
                </li>

                 <li class="nav-header font-weight-bold">Market Place</li>

                 <!-- COOLFIX -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <img src="/assets/images/coolfix/Coolfix.png" class="w40p" title="Coolfix">
                    </a>
                </li>

                <!-- SETTINGS -->
                <li class="nav-header font-weight-bold">Settings</li>

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="" class="nav-link<?php echo $page == 'settings' ? ' active' : '' ?>">
                        <i class="fas fa-lock nav-icon"></i>
                        <p>Password</p>
                    </a>
                </li>


            </ul>
            <!-- /.sidebar-menu -->

		</nav>

        <div class="py-5 my-4">
        </div>
        
	</div>
    
    <div class="sidebar-footer">
        <div class="px-2 py-2 sidebar-footer-color">
            <div class="user-panel d-flex border-0">
                <div class="image my-auto mr-1">
                    <img src="<?php echo $_SESSION['sys_photo']; ?>" class="img-circle elevation-4" width="40">
                </div>
                <div class="info">
                    <p class="mb-0"><a href="/profile" class="text-white"><?php echo $_SESSION['sys_fullname']; ?></a></p>
                    <p class="mb-0 text-white">Admin</p>
                </div>
            </div>      
        </div>
    </div>

</aside>