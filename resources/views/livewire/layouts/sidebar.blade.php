 <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                         @php
                        // $data = getTodayTransactionCount();
                        @endphp
                        {{-- <li class="menu-title">Navigation</li> --}}
                        <li>
                            <a href="/dashboard" data-toggle="tooltip" data-placement="right" title="{{ __('messages.Dashboard') }}">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> {{ __('messages.Dashboard') }} </span>
                            </a>
                        </li>
                        @if (Session::get('auth')->role_name === 'Admin')
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="mdi mdi-table-settings"></i>
                                    <span>{{ __('messages.Payment Config') }}</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{ route('gateway.account.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Gateway Account') }}">{{ __('messages.Gateway Account') }}</a></li>
                                    <li><a href="{{ route('payment.channel.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Gateway Payment Channel') }}">{{ __('messages.Payment Channel') }}</a></li>
                                    <li><a href="{{ route('channel.parameter.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Gateway Channel Parameters') }}">{{ __('messages.Channel Parameters') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('agent.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Agent Management') }}">
                                    <i class="mdi mdi-account-settings-outline"></i>
                                    <span> {{ __('messages.Agent Management') }} </span>
                                </a>
                            </li>
                        @endif

                        @if (Session::get('auth')->role_name === 'Admin'  || Session::get('auth')->role_name === 'Agent')
                           <li>
                                <a href="{{ route('merchant.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Merchant Management') }}">
                                    <i class="mdi mdi-smart-card-outline"></i>
                                    <span> {{ __('messages.Merchant Management') }} </span>
                                </a>
                            </li>
                        @endif
                        @if (Session::get('auth')->role_name === 'Admin')
                           <li>
                                <a href="{{ route('merchant.configure.gateway') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Assign gateways with merchants') }}">
                                    <i class="mdi mdi-merge"></i>
                                    <span> {{ __('messages.Merchant Config') }} </span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('transactions.deposit') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Deposit Transactions') }}">
                                <i class="mdi mdi-file-document-box-check-outline"></i>
                                <span class="badge badge-warning badge-pill float-right">{{ $todayDepositCount > 0 ?   $todayDepositCount  : '' }}</span>
                                <span>{{ __('messages.Deposit Transactions') }} </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('transactions.withdraw') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Withdraw Transactions') }}">
                                <i class="mdi mdi-google-pages"></i>
                                <span class="badge badge-warning badge-pill float-right">{{ $todayWithdrawCount > 0 ?   $todayWithdrawCount  : '' }}</span>
                                <span style="font-size:14px">{{ __('messages.Withdraw Transactions') }} </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoice.qrcode.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Summary Report') }}">
                                <i class="mdi mdi-poll"></i>
                                <span> {{ __('messages.Summary Report') }} </span>
                            </a>
                        </li>
                        @if (Session::get('auth')->user_name == 'FCmerchant001')
                            <li>
                                <a href="{{ route('generate.FCQR') }}" data-toggle="tooltip" data-placement="right" title="{{ __('messages.Generate QR') }}" target="_blank">
                                    <i class="mdi mdi-qrcode-scan"></i>
                                    <span> {{ __('messages.Generate QR') }} </span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('user.profile') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Profile') }}">
                                <i class="mdi mdi-account-outline"></i>
                                <span> {{ __('messages.Profile') }} </span>
                            </a>
                        </li>
                         @if (Session::get('auth')->role_name === 'Admin')
                           <li>
                                <a href="{{ route('user.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.All User') }}">
                                    <i class="mdi mdi-settings-box"></i>
                                    <span> {{ __('messages.All User') }} </span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="#" wire:click="logout" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Logout') }}">
                                <i class="mdi mdi-logout-variant"></i>
                                <span> {{ __('messages.Logout') }} </span>
                            </a>
                        </li>
                        {{-- // for Pusher code START --}}
                                <!-- Hidden audio element -->
                                <audio id="notificationAudio" preload="auto">
                                    <source src="{{ asset('/audio/notifcation.mp3') }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <button onclick="document.getElementById('notificationAudio').play()"></button>

                                <!-- Include jQuery -->
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <!-- Include Toastr JS -->
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                                
                                <!-- Your app.js or bootstrap.js script -->
                                <script src="{{ asset('/build/assets/app-Fdt-UU-v.js') }}"></script>
                                {{-- // for Pusher code END --}}
                       
                        
                       
                        

                       
                       

                    

                       
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->