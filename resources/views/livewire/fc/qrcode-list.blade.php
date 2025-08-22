<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
                                            <td> {{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
                                            <td> <!-- Display QR Code as SVG -->{!! QrCode::size(100)->generate($row->qr_img_url) !!}</td>
                                            <td>
                                                <a href="#custom-modal" class="view-record-btn btn btn-primary waves-effect waves-light" data-id="{{ $row->id }}" data-animation="blur" data-plugin="custommodal"
                                                data-overlaySpeed="100" data-overlayColor="#36404a">{{ __('messages.View') }}</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td></td><td></td><td></td><td></td><td>{{ __('messages.Record not found') }}!</td><td></td><td></td></td><td></td><td></td><td></td><td>
                                        </tr>
                                        @endforelse
                                        
                                        </tbody>
                                    </table>
                                  
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
<!-- Modal START-->
    <div id="custom-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title text-center">{{ __('messages.View') }}</h4>
        <div class="custom-modal-text text-muted">
            <table class="table table-bordered test" style="padding: 7px 10px; !important">
                    <tr>
                        <td style="width: 25%; background-color: #6c6c70 !important; color: white;">{{ __('messages.Customer Name') }}</td>
                        <td class="customer_name"></td>
                        <td style="width: 25%;"  colspan="2" rowspan="4">
                            {{-- {!! QrCode::size(200)->generate("<span>class='qr-content'</span>") !!} --}}
                            <div id="qr-container"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 25%; background-color: #6c6c70 !important; color: white;">{{ __('messages.Invoice Number') }}</td>
                        <td class="invoice_number"></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; background-color: #6c6c70 !important; color: white;">{{ __('messages.Amount') }}</td>
                        <td class="amount"></td>
                    </tr>
            </table>
        </div>
    </div>
<!-- Modal START-->
<script>
$(document).ready(function() {
    $('.view-record-btn').click(function() {
        let recordId = $(this).data('id');
        // alert(recordId);
        $.ajax({
            url: '/get-record/' + recordId,
            type: 'GET',
            success: function(response) {
                $('.customer_name').html(response.customer_name);
                $('.invoice_number').html(response.invoice_number);
                $('.amount').html(response.amount);
                // $('.qr-content').html(response.qr_img_url);
             
                $('#qr-container').empty();
                // Generate new QR code with value of response.qr_img_url
                new QRCode(document.getElementById("qr-container"), {
                    text: response.qr_img_url,
                    width: 200,
                    height: 150
                });
            },
            error: function() {
                alert('Failed to fetch record.');
            }
        });
    });
});
</script>
                   
                        
</div>
