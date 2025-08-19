<div>
    <style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  /* background-color: #2196F3; */
  background-color : rgb(27, 185, 154);
}

input:focus + .slider {
  box-shadow: 0 0 1px rgb(27, 185, 154);
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
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
                    <a href="#custom-modal" class="btn btn-success waves-effect waves-light float-right" data-animation="door" data-plugin="custommodal" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="fas fa-plus"></i> {{ __('messages.Add Gateway Account') }}</a>
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>{{ __('messages.Order Id') }}</th>
                                <th>{{ __('messages.Gateway Account') }}</th>     {{-- For FC Department --}}
                            <th>{{ __('messages.Payment Method') }} </th>
                            <th>{{ __('messages.URL ') }} </th>
                            <th>{{ __('messages.Created Time') }}</th>
                            <th>{{ __('messages.Status') }}</th>
                            <th>{{ __('messages.Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $index = 0; @endphp
                            @forelse($record as $row)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $row->gateway_name ?? '' }}</td>
                            <td>{{ $row->payment_method ?? '' }}</td>
                            <td>{{ $row->website_url ?? '' }}</td>
                            <td> {{ $row->created_at ? $row->created_at->format('d-m-Y h:i:s A') : '' }}</td>
                            <td>
                                <label class="switch">
                                <input type="checkbox" class="toggle-status" data-id="{{ $row->id }}" {{ $row->status == 1 ? 'checked' : '' }}>
                                <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <a href="#custom-modal" class="view-record-btn btn btn-primary waves-effect waves-light" data-id="{{ $row->id }}" data-animation="blur" data-plugin="custommodal"
                                data-overlaySpeed="100" data-overlayColor="#36404a"><i class="fas fa-pencil-alt"></i></a>
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
<!-- Modal START-->
    <div id="custom-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title text-center">{{ __('messages.Edit') }}</h4>
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
<script>
$(document).on('change', '.toggle-status', function () {
    let id = $(this).data('id');
    let status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: "{{ route('gateway.toggleStatus') }}", // route to update status
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            id: id,
            status: status
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    title: "Success!",
                    text: "Status updated successfully",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert("Failed to update status!");
            }
        },
        error: function () {
            alert("Something went wrong!");
        }
    });
});
</script>

                   
                        
</div>
