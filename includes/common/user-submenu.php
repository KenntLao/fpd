
<nav class="navbar navbar-expand navbar-light bg-white border-top border-bottom">  
    <ol class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link<?php if($page == 'user-units') { echo ' active'; } ?>" href="/user-units"><?php echo renderLang($users_user_portal_my_units); ?></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link<?php if($page == 'user-transactions') { echo ' active'; } ?>" href="/user-transactions"><?php echo renderLang($users_user_portal_my_transactions); ?></a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link<?php if($page == 'user-complaints' || $page == 'user-gate-pass' ||$page == 'user-moveinout-requests' || $page == 'user-reservations') { echo ' active'; } ?>" id="dropdownMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?php echo renderLang($users_user_portal_help_desk); ?></a>
            <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">
                <li><a class="dropdown-item" href="/user-complaints"><?php echo renderLang($users_user_portal_complaints); ?></a>
                </li>
                <!-- Level two dropdown-->
                <li class="dropdown-submenu">
                    <a id="dropdownMenu2" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle test"><?php echo renderLang($users_user_portal_gate_pass); ?></a>
                      <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">
                        <li><a tabindex="-1" href="/user-gate-pass-visitors" class="dropdown-item">Visitors</a></li>
                        <li><a href="/user-gate-pass-moveinout-requests" class="dropdown-item">Move In/Out Requests</a></li>
                        <li><a href="/user-gate-pass-service-provider" class="dropdown-item">Service Provider</a></li>
                        <li><a href="/user-gate-pass-employee" class="dropdown-item">Employee</a></li>
                      </ul>
                </li><!-- End Level two -->
                <!-- Level two dropdown-->
                <li class="dropdown-submenu">
                    <a id="dropdownMenu3" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle test"><?php echo renderLang($users_user_portal_reservation); ?></a>
                      <ul aria-labelledby="dropdownMenu3" class="dropdown-menu border-0 shadow">
                        <li><a href="/user-reservation-boardroom" class="dropdown-item">Boardroom</a></li>
                        <li><a href="/user-reservation-com" class="dropdown-item">COM</a></li>
                      </ul>
                </li><!-- End Level two -->
            </ul>
      </li><!-- End Level one -->
      <li class="nav-item">
        <a class="nav-link<?php if($page == 'user-transactions') { echo ' active'; } ?>" href="#"><?php echo renderLang($users_user_portal_settings); ?></a>
      </li>
    </ol>
</nav>