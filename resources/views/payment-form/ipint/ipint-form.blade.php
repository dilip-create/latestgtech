
@extends('components.layouts.controllerlayouts')
@section('content')
<?php
    $referenceNo="GZTRN".time().generateRandomString(3);
    function generateRandomString($length = 3) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {$randomString .= $characters[rand(0, $charactersLength - 1)];}
        return $randomString;
    }
?>
<style>
    .auth-form {
        padding: 20px 20px !important;
    }
    .form-control {
        height: 3rem !important;
        border: 2px solid gray;
    }
    .justify-content-center {
        margin-top: 10px;
    }
 /* Fullscreen spinner container */
    .spinner-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Opaque background */
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .spinner-container img {
        width: 100px;
        height: 100px;
    }
</style>
 <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-7">
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h2 class="text-muted text-uppercase py-3"><b>Demo Merchant Crypto Deposit</b></h2>
                                    </div>
                                    <form role="form" action="{{ route('apiroute.ipint.checkout') }}" method="GET" id="paymentForm" class="parsley-examples" data-parsley-validate novalidate>
                                    @csrf
                                        <input type="hidden" name="merchant_code" value="testmerchant005">
                                        <input type="hidden" name="channel_id" value="4">   {{-- // for new IpInt gateway --}}
                                        <input type="hidden" name="callback_url" value="{{ route('apiroute.ipint.depositResponse') }}">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Reference ID</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="referenceId" placeholder="Enter Reference ID" value="<?php echo $referenceNo; ?>" readonly type="text">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Currency</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="Currency" required>
                                                    <option value="">---</option>
                                                    <option value="EUR">EUR</option>
                                                    <option value="MYR">MYR</option>
                                                    <option value="THB">THB</option>
                                                    <option value="VND">VND</option>
                                                    <option value="IDR">IDR</option>
                                                    <option value="USD" selected>USD</option>
                                                    <option value="PHP">PHP</option>
                                                    <option value="INR">INR</option>
                                                    <option value="CNY">CNY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Amount</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="amount" id="amountInput" placeholder="Enter your Amount" value="100" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="customer_name" class="col-md-4 col-form-label"><strong>Customer Name</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input  class="form-control" name="customer_name" placeholder="Enter cumtomer name" type="text" required>
                                                @error('customer_name')
                                                <label class="error" for="customer_name">{{ $message }}</label> 
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="customer_email" class="col-md-4 col-form-label"><strong>Customer Email</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="customer_email"  placeholder="Enter Customer Email" type="text">
                                            </div>
                                            @error('customer_email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div><br/>
                                        <!-- Spinner -->
                                        <div class="spinner-container">
                                            <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..."> <!-- Replace with your spinner image URL -->
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" id="submitBtn" class="btn btn-block btn-lg btn-primary waves-effect waves-light">Pay Now <span id="amountLabel">100</span>฿ <i class="mdi mdi-arrow-right"></i></button>
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
<script>
    const form = document.getElementById('paymentForm');
    const spinnerContainer = document.querySelector('.spinner-container');
    form.addEventListener('submit', function () {
        var btn = $("#submitBtn");
                btn.html('<span class="spinner-border spinner-border-sm"></span> Processing...'); 
                btn.prop("disabled", true);
        spinnerContainer.style.display = 'flex'; // Show spinner with opaque background
    });
</script>
<script>
$(document).ready(function() {
    $("#amountInput").on("input", function() {
        let amount = $(this).val();
        // Regular expression to allow only integers or decimals
        let regex = /^[0-9]*\.?[0-9]*$/;
        // If input doesn't match, show alert and clear invalid characters
        if (!regex.test(amount)) {
            alert("Amount should be integer or decimal value !");
            // Remove invalid characters
            $(this).val(amount.replace(/[^0-9.]/g, ''));
            amount = $(this).val();
        }
        // If input is empty, set amount = 0
        if (amount === "") {
            amount = 0;
        }
        // Update the button text dynamically
        $("#amountLabel").text(amount);
    });
});

</script>
@endsection
