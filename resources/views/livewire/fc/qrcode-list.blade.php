<div>
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/">GTech</a></li>
                            <li class="breadcrumb-item active">{{ __('messages.Summary Report') }}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ __('messages.Summary Report') }}</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        
          <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>{{ __('messages.Order Id') }}</th>
                                             <th>{{ __('messages.Invoice Number') }}</th>     {{-- For FC Department --}}
                                            <th>{{ __('messages.Customer Name') }} </th>
                                            <th>{{ __('messages.Amount') }} </th>
                                            <th>{{ __('messages.Created Time') }}</th>
                                            <th>{{ __('messages.QR Code') }} </th>
                                            <th>{{ __('messages.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $index = 0; @endphp
                                            @forelse($record as $row)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $row->invoice_number ?? '' }}</td>
                                            <td>{{ $row->customer_name ?? '' }}</td>
                                            <td>{{ $row->amount ?? '' }}</td>
                                            <td> {{ $row->created_at ?? '' }}</td>
                                            <td> <!-- Display QR Code as SVG -->
                                        {!! QrCode::size(100)->generate($row->qr_img_url) !!}</td>
                                           
                                            <td>
                                                {{ $row->id ?? '' }}
                                                <button class="btn btn-primary btn-sm" type="button" wire:click="$dispatch('openmodal', { id: {{ $row->id }} })">View</button>
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
                        <livewire:fc.show-q-r-modal />
</div>
