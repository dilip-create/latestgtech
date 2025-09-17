  <div class="navbar-custom">
                                <!-- Include jQuery -->
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <!-- Include Toastr JS -->
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
            <a class="nav-link dropdown-toggle waves-effect waves-light noti-wrapper" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-bell-outline noti-icon"></i>
                <span class="noti-icon-badge">{{ $NotificationCount ?? ''}}</span>
            </a>


            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="font-16 text-white m-0">
                        <span class="float-right">
                            <a href="" class="text-white">
                                {{-- <small>Clear All</small> --}}
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">

                    @forelse ($NotificationData as $index => $unread)
                                @php
                                    $record = json_decode($unread->data, true); 
                                @endphp
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info">
                                    <i class="mdi mdi-bell-outline"></i>
                                </div>
                                <p class="notify-details">{{ ucfirst($unread->msg) ?? '' }}
                                    <small class=" text-success">{{ trans('messages.Trans ID') }}: {{ $record['transaction_id'] ?? '' }}</small>
                                    <small class=" text-danger">{{ trans('messages.Status') }}: {{ $record['status'] ?? '' }}</small>
                                    <small class="">{{ $unread->created_at->diffForHumans() }}</small>
                                </p>
                            </a>
                    @empty
                            <a href="javascript:void(0);" class=" notify-item">
                                    <p class="notify-details">There is no have any Notification! </p>  
                            </a>
                    @endforelse
                  
                    
                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-primary notify-item notify-all">
                    {{ trans('messages.mark all as read') }}
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>
          {{-- // for Pusher code START --}}
                                <!-- Hidden audio element -->
                                <audio id="notificationAudio" preload="auto">
                                    <source src="{{ asset('/audio/notifcation.mp3') }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <button onclick="document.getElementById('notificationAudio').play()"></button>

                               
                                
                                <!-- Your app.js or bootstrap.js script -->
                                <script src="{{ asset('/build/assets/app-BX0Wc3vv.js') }}"></script>
                                {{-- // for Pusher code END --}}

        

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{ URL::to('newassets/images/users/avatar-1.jpg') }}" alt="user-image" class="rounded-circle">
                <span class="d-none d-sm-inline-block ml-1 font-weight-medium">Hello, <b>{{ Session::get('auth')->user_name ?? '' }}</b></span>
                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
            </a>
            {{-- <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow text-white m-0">{{ __('messages.Welcome') }} !</h6>
                </div>
                <!-- item-->
                <a href="{{ route('user.profile') }}" wire:navigate class="dropdown-item notify-item">
                    <i class="mdi mdi-account-outline"></i>
                    <span>{{ __('messages.Profile') }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <!-- item-->
                <a href="#" wire:click="logout" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout-variant"></i>
                    <span>{{ __('messages.Logout') }}</span>
                </a>
            </div> --}}
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