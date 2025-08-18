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
                                <a href="{{ route('agent.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Agent Management') }}">
                                    <i class="mdi mdi-account-outline"></i>
                                    <span> {{ __('messages.Agent Management') }} </span>
                                </a>
                            </li>
                             <li>
                            <a href="javascript: void(0);">
                                <i class="mdi mdi-table-settings"></i>
                                <span>{{ __('messages.Payment Config') }}</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="{{ route('gateway.account.list') }}" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Gateway Account') }}">{{ __('messages.Gateway Account') }}</a></li>
                                <li><a href="tables-datatable.html">Data Tables</a></li>
                               
                            </ul>
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
                        <li>
                            <a href="#" wire:click="logout" wire:navigate data-toggle="tooltip" data-placement="right" title="{{ __('messages.Logout') }}">
                                <i class="mdi mdi-logout-variant"></i>
                                <span> {{ __('messages.Logout') }} </span>
                            </a>
                        </li>
                       
                        
                        {{-- <li class="menu-title mt-2">Components</li>
                        <li>
                            <a href="javascript: void(0);">
                                <i class="mdi mdi-black-mesa"></i>
                                <span> Icons </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="icons-materialdesign.html">Material Design</a></li>
                                <li><a href="icons-ionicons.html">Ion Icons</a></li>
                                <li><a href="icons-fontawesome.html">Font awesome</a></li>
                                <li><a href="icons-themify.html">Themify Icons</a></li>
                                <li><a href="icons-simple-line.html">Simple line Icons</a></li>
                                <li><a href="icons-weather.html">Weather Icons</a></li>
                                <li><a href="icons-pe7.html">PE7 Icons</a></li>
                                <li><a href="icons-typicons.html">Typicons</a></li>
                            </ul>
                        </li>

                        

                        <li>
                            <a href="javascript: void(0);">
                                <i class="mdi mdi-table-settings"></i>
                                <span> Tables </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="tables-basic.html">Basic Tables</a></li>
                                <li><a href="tables-datatable.html">Data Tables</a></li>
                                <li><a href="tables-responsive.html">Responsive Table</a></li>
                                <li><a href="tables-tablesaw.html">Tablesaw</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);">
                                <i class="mdi mdi-poll"></i>
                                <span> Charts </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="charts-flot.html">Flot Charts</a></li>
                                <li><a href="charts-morris.html">Morris Charts</a></li>
                                <li><a href="charts-chartjs.html">Chartjs</a></li>
                                <li><a href="charts-peity.html">Peity Charts</a></li>
                                <li><a href="charts-chartist.html">Chartist Charts</a></li>
                                <li><a href="charts-c3.html">C3 Charts</a></li>
                                <li><a href="charts-sparkline.html">Sparkline Charts</a></li>
                                <li><a href="charts-knob.html">Jquery Knob</a></li>
                            </ul>
                        </li> --}}

                    

                       
                    </ul>

                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->