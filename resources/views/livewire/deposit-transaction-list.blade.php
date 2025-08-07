<div>
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">GTech</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Deposit Transactions') }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ __('messages.Deposit Transactions') }}</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        
          <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="card-body" id="success">
                                        <div class="mb-3 p-2 border bg-v-light">
                                            <ul class="list-inline right-bar-list mb-0">
                                                <li class="header-title list-inline-item"><b>{{ __('messages.Result:') }}</b></li><span class="d-none d-md-inline fw-bold">--</span>
                                                <li class="header-title list-inline-item"><b>{{ __('messages.Total Amount:') }} <span id="order_success_sum" class="text text-primary">{{ $totalAmount ?? '00' }}</span></b></li> <span class="d-none d-md-inline">|</span>
                                                <li class="header-title list-inline-item"><b>{{ __('messages.Total MDR Fee:') }} <span id="payment_count" class="text text-danger">{{ $totalmdrfee ?? '00' }}</span></b></li> <span class="d-none d-md-inline">|</span>
                                                <li class="header-title list-inline-item"><b>{{ __('messages.Total Net Amount:') }} <span id="order_amount_sum" class="text text-success">{{ $totalNetAmount ?? '00' }}</span></b></li> 
                                                {{-- <li class="list-inline-item">{{ __('messages.Success order count:') }} <span id="order_success_count"></span></li> <span class="d-none d-md-inline">|</span> --}}
                                            </ul>
                                        </div>
                                    </div>
                                    <h4 class="header-title">{{ __('messages.Status') }}</h4>
                                    <p class="sub-header">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <select wire:model.live="statusFilter" class="form-control custom-select">
                                                    <option value="all">{{ __('messages.All') }}</option>
                                                    <option value="pending">{{ __('messages.pending') }}</option>
                                                    <option value="success">{{ __('messages.Success') }}</option>
                                                    <option value="processing">{{ __('messages.processing') }}</option>
                                                    <option value="failed">{{ __('messages.Failed') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-2">
                                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search here"/>
                                            </div>
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-6">
                                                @php
                                                    $buttons = [
                                                        'today' => 'Today',
                                                        'yesterday' => 'Yesterday',
                                                        '7days' => '7 days ago',
                                                        'this_week' => 'This week',
                                                        'last_week' => 'Last week',
                                                        'this_month' => 'This month',
                                                        'last_month' => 'Last month',
                                                        'this_year' => 'This year',
                                                        'last_year' => 'Last year',
                                                    ];
                                                @endphp

                                                @foreach($buttons as $key => $label)
                                                    <button type="button"
                                                            wire:click="$set('dateFilter', '{{ $key }}')"
                                                            class="btn {{ $dateFilter === $key ? 'btn-primary' : 'btn-outline-primary' }} waves-effect waves-light">
                                                        {{ $label }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>{{ __('messages.Order Id') }}</th>
                                            <th>{{ __('messages.Created Time') }}</th>
                                            <th>{{ __('messages.Transaction ID') }}</th>
                                            @if (Session::get('auth')->role_name == 'Admin') 
                                            <th>{{ __('messages.Merchant Code') }}</th>
                                            @endif
                                            @if(Session::get('auth')->merchant_id  == '1')       
                                             <th>{{ __('messages.Invoice Number') }}</th>     {{-- For FC Department --}}
                                            @else
                                            <th>{{ __('messages.Reference ID') }}</th>
                                            @endif
                                            <th>{{ __('messages.Customer Name') }} </th>
                                            <th>{{ __('messages.Amount') }} </th>
                                            <th>{{ __('messages.MDR') }} </th>
                                            <th>{{ __('messages.Net') }} </th>
                                            <th>{{ __('messages.Currency') }}</th>
                                            <th>{{ __('messages.Status') }}</th>
                                            <th>{{ __('messages.Action') }}</th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                            @php $index = 0; @endphp
                                            @forelse($transactionlist as $row)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
                                            <td>{{ $row->systemgenerated_TransId ?? '' }}</td>
                                            @if (Session::get('auth')->role_name == 'Admin') 
                                             <td>{{ $row->merchant_code ?? '' }}</td>
                                            @endif
                                            <td>{{ $row->reference_id ?? '' }}</td>
                                            <td>{{ $row->customer_name ?? '' }}</td>
                                            <td>{{ $row->amount ?? '' }}</td>
                                            <td>{{ $row->mdr_fee_amount ?? '' }}</td>
                                            <td>{{ $row->net_amount ?? '' }}</td>
                                            <td>{{ $row->Currency ?? '' }}</td>
                                            <td>
                                            @if($row->payment_status == 'pending')
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Pending</button>
                                            @elseif($row->payment_status == 'processing')
                                            <button type="button" class="btn btn-warning waves-effect waves-light">Processing..</button>
                                            @elseif($row->payment_status == 'failed')
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Failed</button>
                                            @else
                                            <button type="button" class="btn btn-success waves-effect waves-light">Success</button>
                                            @endif
                                            </td>
                                            <td>
                                                <div class="btn-group mt-1 mr-1">
                                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" class="cursor-pointer text-[#98A6AD]" height="20" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"></path></svg> <i class="mdi mdi-chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text text-danger" href="{{ url('sendDepositNotification/' . base64_encode($row->id)) }}" target="_blank">{{ __('messages.Resend Callback') }}</a>
                                                    </div>
                                                </div>
                                            </td>  
                                        </tr>
                                        @empty
                                        <tr>
                                            <td></td><td></td><td></td><td></td><td></td><td>Record not founds</td><td></td><td></td></td><td></td><td></td><td></td><td>
                                        </tr>
                                        @endforelse
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
</div>
