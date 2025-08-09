  
  <div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list dropdown d-none d-lg-inline-block ml-2" id="Langchange">
            <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                       @if(session()->get('locale') == 'th')
                        <img src="{{ URL::to('newassets/images/flags/th.png') }}" alt="lang-image" height="12">
                        @else
                        <img src="{{ URL::to('newassets/images/flags/us.jpg') }}" alt="lang-image" height="12">
                        @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown">
                <!-- item-->
                <a href="{{ route('change.lang', ['lang' => 'en']) }}" class="dropdown-item notify-item" id="en">
                    <img src="{{ URL::to('newassets/images/flags/us.jpg') }}" alt="lang-image" class="mr-1" height="12"> 
                    <span class="align-middle">English</span>
                </a>

                <!-- item-->
                <a href="{{ route('change.lang', ['lang' => 'th']) }}" class="dropdown-item notify-item" id="th">
                    <img src="{{ URL::to('newassets/images/flags/th.png') }}" alt="lang-image" class="mr-1" height="12"> 
                    <span class="align-middle">Thai</span>
                </a>
            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-bell-outline noti-icon"></i>
                <span class="noti-icon-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="font-16 text-white m-0">
                        <span class="float-right">
                            <a href="" class="text-white">
                                <small>Clear All</small>
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-success">
                            <i class="mdi mdi-settings-outline"></i>
                        </div>
                        <p class="notify-details">New settings
                            <small class="text-muted">There are new settings available</small>
                        </p>
                    </a>
        
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-bell-outline"></i>
                        </div>
                        <p class="notify-details">Updates
                            <small class="text-muted">There are 2 new updates available</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-danger">
                            <i class="mdi mdi-account-plus"></i>
                        </div>
                        <p class="notify-details">New user
                            <small class="text-muted">You have 10 unread messages</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-info">
                            <i class="mdi mdi-comment-account-outline"></i>
                        </div>
                        <p class="notify-details">Caleb Flakelar commented on Admin
                            <small class="text-muted">4 days ago</small>
                        </p>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <div class="notify-icon bg-secondary">
                            <i class="mdi mdi-heart"></i>
                        </div>
                        <p class="notify-details">Carlos Crouch liked
                            <b>Admin</b>
                            <small class="text-muted">13 days ago</small>
                        </p>
                    </a>
                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-primary notify-item notify-all">
                    View all
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>

        

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ URL::to('newassets/images/users/avatar-1.jpg') }}" alt="user-image" class="rounded-circle">
                <span class="d-none d-sm-inline-block ml-1 font-weight-medium">Hello, <b>{{ Session::get('auth')->user_name ?? '' }}</b></span>
                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow text-white m-0">{{ __('messages.Welcome') }} !</h6>
                </div>
                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-outline"></i>
                    <span>{{ __('messages.Profile') }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <!-- item-->
                <a href="#" wire:click="logout" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout-variant"></i>
                    <span>{{ __('messages.Logout') }}</span>
                </a>
            </div>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="/" class="logo text-center logo-dark">
            <span class="logo-lg">
                <img src="{{ URL::to('newassets/images/logo-Gtech.png') }}" alt="" height="22">
                <!-- <span class="logo-lg-text-dark">Uplon</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-lg-text-dark">U</span> -->
                <img src="{{ URL::to('newassets/images/logo-Gtech.png') }}" alt="" height="15">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>
    </ul>
</div>