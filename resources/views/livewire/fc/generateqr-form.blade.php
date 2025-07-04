<div>
    <style>
     .form-control {
        height: 3rem !important;
        border: 2px solid gray;
    }
</style>

        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-7 pt-5">
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="my-3">
                                            <a href="#">
                                                <span><img src="{{ URL::to('newassets/images/logo-Gtech.png') }}" alt="" height="28"></span>
                                            </a>
                                        </div>
                                        <h5 class="text-muted text-uppercase py-3 font-16">Generate QR Code</h5>
                                    </div>
                                    <form wire:submit.prevent="saveQRdata" method="POST" class="mt-2">
                                    @csrf
                                        <div class="form-group">
                                                <label for="customer_name"><strong>Enter Customer Name</strong><span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" wire:model.live="customer_name" placeholder="Enter customer name" value="">
                                                @error('customer_name')
                                                <label class="error" for="customer_name">{{ $message }}</label> 
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                                <label for="Currency"><strong>Select Currency</strong><span class="text-danger">*</span></label>
                                                <select class="form-control custom-select" wire:model.live="Currency">
                                                    <option value="THB">THB</option>
                                                    <option value="USD">USD</option>
                                                    <option value="USDT">USDT</option>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                                <label for="userName"><strong>Enter Amount</strong><span class="text-danger">*</span></label>            
                                                <input type="text" class="form-control @error('amount') is-invalid @enderror" wire:model.live="amount" placeholder="Enter amount should be in decimal such as 100.00" value="">
                                                @error('amount')
                                                <label class="error" for="amount">{{ $message }}</label> 
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                                <label for="userName"><strong>Enter Invoice Number</strong><span class="text-danger">*</span></label>            
                                                <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" wire:model.live="invoice_number" placeholder="Enter invoice here" value="">
                                                @error('invoice_number')
                                                <label class="error" for="invoice_number">{{ $message }}</label> 
                                                @enderror
                                        </div><br>
                                        <div class="form-group text-center">
                                            <button class="btn btn-block btn-lg btn-primary waves-effect waves-light" type="submit"> Generate <i class="mdi mdi-arrow-right"></i></button>
                                        </div>
                                    </form>
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->
</div>
