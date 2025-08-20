<div>
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">GTech</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Withdraw Transactions') }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ __('messages.Withdraw Transactions') }}</h4>
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
                                             <div class="col-sm-1"></div>
                                            <div class="col-sm-7">&nbsp;&nbsp;&nbsp;&nbsp;
                                                @php
                                                    $buttons = [
                                                        'today'       => __('messages.Today'),
                                                        'yesterday'   => __('messages.Yesterday'),
                                                        '7days'       => __('messages.7 days ago'),
                                                        'this_week'   => __('messages.This week'),
                                                        'last_week'   => __('messages.Last week'),
                                                        'this_month'  => __('messages.This month'),
                                                        'last_month'  => __('messages.Last month'),
                                                        'this_year'   => __('messages.This year'),
                                                        'last_year'   => __('messages.Last year'),
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
                                            <td>{{ $row->reference_id ?? '' }}</td>
                                            <td>{{ $row->customer_name ?? '' }}</td>
                                            <td>{{ $row->total ?? '' }}</td>
                                            <td>{{ $row->mdr_fee_amount ?? '' }}</td>
                                            <td>{{ $row->net_amount ?? '' }}</td>
                                            <td>{{ $row->Currency ?? '' }}</td>
                                            <td>
                                            @if($row->status == 'pending')
                                            <button type="button" class="btn btn-primary waves-effect waves-light">Pending</button>
                                            @elseif($row->status == 'processing')
                                            <button type="button" class="btn btn-warning waves-effect waves-light">Processing..</button>
                                            @elseif($row->status == 'failed')
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
                                                        <a class="dropdown-item" href="#">{{ __('messages.Resend Callback') }}</a>
                                                    </div>
                                                </div>
                                            </td>  
                                        </tr>
                                        @empty
                                        <tr>
                                            <td></td><td></td><td></td><td></td><td>Record not founds</td><td></td><td></td></td><td></td><td></td><td></td><td>
                                        </tr>
                                        @endforelse
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
</div>
