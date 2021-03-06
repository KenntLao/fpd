<nav class="main-header navbar
    {{ config('adminlte.classes_topnav_nav', 'navbar-expand-md') }}
    {{ config('adminlte.classes_topnav', 'navbar-white navbar-light') }}">

    {{-- Navbar left links --}}
    <ul class="navbar-nav">
        {{-- Left sidebar toggler link --}}
        @include('adminlte::partials.navbar.menu-item-left-sidebar-toggler')

        {{-- Configured left links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item')

        {{-- Custom left links --}}
        @yield('content_top_nav_left')
    </ul>

    {{-- Navbar right links --}}
    <ul class="navbar-nav ml-auto">
        @if($emp !== '')
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">
                    {{count($emp->notifications)}}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Notifications</span>
                @foreach($emp->notifications as $notification)
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item notif-item">
                    <i class="fas fa-clock mr-2"></i> {{$notification->data['notif_message']}}
                    <p>{{$notification->created_at->diffForHumans()}}</p>
                </a>

                @endforeach

                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        @else
        @endif
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(isset($_SESSION['sys_id']))
                <div class="main-profile-photo">
                    <img src="{{asset($_SESSION['sys_hris_photo'])}}">
                </div>{{$_SESSION['sys_fullname']}}
                @endif
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @if($_SESSION['sys_account_mode'] == 'employee')
                    @if(isset($_SESSION['sys_id']))
                    <div class="dropdown-main-profile-photo">
                        <img src="{{asset($_SESSION['sys_hris_photo'])}}">
                    </div>
                    <h5><a href="/hris/pages/personalInformation/profile/index">{{$_SESSION['sys_fullname']}}</a></h5>
                    @endif
                    <div class="dropdown-divider"></div>
                @endif
                <a class="dropdown-item" href="/hris/logout"><i class="fa fa-sign-out-alt mr-2" aria-hidden="true"></i> Log out</a>
            </div>
        </li>
        {{-- Custom right links --}}
        @yield('content_top_nav_right')
        {{-- Configured right links --}}
        @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')

        {{-- User menu link --}}
        @if(Auth::user())
        @if(config('adminlte.usermenu_enabled'))
        @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
        @else
        @include('adminlte::partials.navbar.menu-item-logout-link')
        @endif
        @endif

        {{-- Right sidebar toggler link --}}
        @if(config('adminlte.right_sidebar'))
        @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
        @endif
    </ul>

</nav>