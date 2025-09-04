
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
        margin-top: 120px;
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
                                    <form role="form" action="{{ route('apiroute.r2p.payin') }}" method="GET" id="paymentForm" class="parsley-examples" data-parsley-validate novalidate>
                                    @csrf
                                        <input type="hidden" name="merchant_code" value="testmerchant005">
                                        <input type="hidden" name="channel_id" value="1">   {{-- // for new Richpay gateway --}}
                                        <input type="hidden" name="callback_url" value="{{ route('apiroute.r2pPayincallbackURL') }}">
                                        
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Reference ID</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="referenceId" placeholder="Enter Reference ID" value="<?php echo $referenceNo; ?>" readonly type="text">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Currency</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="Currency" value="THB" readonly type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Amount</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="amount" placeholder="Enter your Amount" value="100" type="text">
                                            </div>
                                        </div>
                                        
                                        <input name="bank_code_character" id="bank_code_character" readonly type="hidden">
                                        <input name="bank_code" id="bank_code" readonly type="hidden">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Customer Name</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input list="browsers" id="browser" class="form-control" name="customer_name" placeholder="Enter cumtomer name" type="text">
                                                <datalist id="browsers">
                                                    <option value="{{ $customer_name ?? '' }}">
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Customer Email</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="Customer Email" id="Customer Email" placeholder="Enter Customer Email" type="text">
                                            </div>
                                            @error('Customer Email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div><br/>
                                        <!-- Spinner -->
                                        <div class="spinner-container">
                                            <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..."> <!-- Replace with your spinner image URL -->
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" id="submitBtn" class="btn btn-block btn-lg btn-primary waves-effect waves-light">Pay Now {{ $amount ?? '' }}฿ <i class="mdi mdi-arrow-right"></i></button>
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

      /* Custom dropdown for select Bank START */
    function toggleDropdown() {
        var dropdownList = document.getElementById("dropdownList");
        var arrow = document.getElementById("arrow");

        dropdownList.style.display = dropdownList.style.display === "block" ? "none" : "block";
        arrow.classList.toggle("rotate");
    }

    function selectBank(element) {
        var selectedText = document.getElementById("selectedText");
        var selectedImg = document.getElementById("selectedImg");
        var bankCodeField = document.getElementById("bank_code");
        var bankCodesymbol = document.getElementById("bank_code_character");
      
        selectedText.innerText = element.innerText.trim();
        selectedImg.src = element.dataset.image;
        bankCodeField.value = element.dataset.value;  // Set the selected bank's data-value
        bankCodesymbol.value = element.dataset.symbol;  // Set the selected bank's data-symbol

        document.getElementById("dropdownList").style.display = "none";
        document.getElementById("arrow").classList.remove("rotate");
    }

    // Close dropdown when clicking outside
    // document.addEventListener("click", function (event) {
    //     var dropdown = document.getElementById("bankDropdown");
    //     if (!dropdown.contains(event.target)) {
    //         document.getElementById("dropdownList").style.display = "none";
    //         document.getElementById("arrow").classList.remove("rotate");
    //     }
    // });
      /* Custom dropdown for select Bank END */
</script>



@endsection
