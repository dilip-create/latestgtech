
@extends('layouts.app')
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
    .form-control {
    height: 2.5rem !important;
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

        /* Spinner image */
        .spinner-container img {
            width: 100px;
            height: 100px;
        }
          /* Custom dropdown for select Bank START */
      .custom-dropdown {
            position: relative;
            width: 100%;
            font-family: Arial, sans-serif;
            height: 3rem !important;
            /* border: 2px solid gray;
            border-radius: 0.5rem; */
        }
        .dropdown-selected {
            height: 2.75rem !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .dropdown-selected img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .dropdown-list {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px;
            cursor: pointer;
            transition: 0.2s;
            font-size: 16px;
        }
        .dropdown-item:hover {
            background: #f0f0f0;
        }
        .dropdown-item img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }
        /* Arrow Indicator */
        .arrow {
            font-size: 27px;
            transition: transform 0.3s;
        }
        .rotate {
            transform: rotate(180deg);
        }
          /* Custom dropdown for select Bank END */
</style>
{!! Toastr::message() !!}
<div class="row justify-content-center h-100 align-items-center">
    <div class="col-md-8">
        <div class="authincation-content">
            <div class="row no-gutters">
                <div class="col-xl-12">
                    <div class="auth-form">
                        <h3 class="text-center mb-4"><b>Test Merchant Withdrawal or Payout</b></h3>
                        <form class="form-horizontal" action="{{ route('apiroute.r2p.payout') }}" method="GET" id="paymentForm">
                            <input type="hidden" name="merchant_code" value="testmerchant005">
                             <input type="hidden" name="product_id" value="28">   {{--for Local 27 || for Live  28 --}}
                            <input type="hidden" name="callback_url" value="{{ route('apiroute.r2pPayoutcallbackURL') }}">
							<div class="row mb-4">
                                <label for="Reference" class="col-md-4 form-label">Reference ID</label>
                                <div class="col-md-8">
								<input class="form-control" name="referenceId" placeholder="Enter Reference ID" value="<?php echo $referenceNo; ?>" required readonly type="text">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="Reference" class="col-md-4 form-label">Currency</label>
                                <div class="col-md-8">
								<input class="form-control" name="Currency" value="THB" required readonly type="text">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="price" class="col-md-4 form-label">Amount</label>
                                <div class="col-md-8">
									<input class="form-control" required name="amount" placeholder="Amount should be minimum 1000" value="1000" type="text">
                                </div>
                            </div> 
                            <div class="row mb-2">
                                <label for="Bank-Code" class="col-md-4 form-label">Bank Name</label>
                                <div class="col-md-8">
                                        <div class="custom-dropdown" id="bankDropdown">
                                            <div class="dropdown-selected" onclick="toggleDropdown()">
                                                <div style="display: flex; align-items: center;">
                                                    <img src="{{ URL::to('assets/images/bank-images/dummy.png') }}" id="selectedImg">
                                                    <span id="selectedText">Select Bank</span>
                                                </div>
                                                <span class="arrow" id="arrow">&#9662;</span> <!-- Downward arrow -->
                                            </div>
                                            <div class="dropdown-list" id="dropdownList">
                                                <div class="dropdown-item" data-symbol="BBL" data-value="002" data-image="{{ URL::to('assets/images/bank-images/BBL.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/BBL.png') }}">
                                                    Bangkok Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KBANK" data-value="004" data-image="{{ URL::to('assets/images/bank-images/KBANK.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/KBANK.png') }}">
                                                    Kasikorn Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KTB" data-value="006" data-image="{{ URL::to('assets/images/bank-images/KTB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/KTB.png') }}">
                                                    Krungthai Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="TMB" data-value="011" data-image="{{ URL::to('assets/images/bank-images/TMB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/TMB.png') }}">
                                                    TMB Thanachart bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="SCB" data-value="014" data-value="" data-image="{{ URL::to('assets/images/bank-images/SCB.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/SCB.jpg') }}" class="img-fluid rounded-circle" alt="">
                                                    Siam Commercial Bank
                                                </div>
                                                
                                                <div class="dropdown-item" data-symbol="CITI N.A" data-value="017" data-value="" data-image="{{ URL::to('assets/images/bank-images/CITI.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/CITI.jpg') }}" class="img-fluid rounded-circle" alt="">
                                                    Citibank N.A.
                                                </div>
                                                <div class="dropdown-item" data-symbol="SCBT" data-value="020" data-value="" data-image="{{ URL::to('assets/images/bank-images/SCBT.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/SCBT.png') }}" class="img-fluid rounded-circle" alt="">
                                                    Standard Chartered Bank (Thailand)
                                                </div>
                                                <div class="dropdown-item" data-symbol="CIMB" data-value="022" data-image="{{ URL::to('assets/images/bank-images/CIMB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/CIMB.png') }}">
                                                    CIMB Thai bank
                                                </div>
                                                
                                                <div class="dropdown-item" data-symbol="UOB" data-value="024" data-image="{{ URL::to('assets/images/bank-images/UOB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/UOB.png') }}">
                                                    UOB Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="BAY" data-value="025" data-image="{{ URL::to('assets/images/bank-images/BAY.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/BAY.jpg') }}">
                                                    Bank of Ayudhya
                                                </div>
                                                <div class="dropdown-item" data-symbol="GOV" data-value="030" data-image="{{ URL::to('assets/images/bank-images/GOV.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/GOV.jpg') }}">
                                                    Government Savings Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="GHB" data-value="033" data-image="{{ URL::to('assets/images/bank-images/GHB.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/GHB.jpg') }}">
                                                    Government Housing Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="AGRI" data-value="034" data-image="{{ URL::to('assets/images/bank-images/AGRI.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/AGRI.png') }}">
                                                    Bank for Agriculture and Agricultural Cooperatives
                                                </div>
                                                <div class="dropdown-item" data-symbol="ISBT" data-value="066" data-image="{{ URL::to('assets/images/bank-images/ISBT.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/ISBT.jpg') }}">
                                                    Islamic Bank of Thailand
                                                </div>
                                                <div class="dropdown-item" data-symbol="TISCO" data-value="067" data-image="{{ URL::to('assets/images/bank-images/TISCO.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/TISCO.png') }}">
                                                    TISCO Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KK" data-value="069" data-image="{{ URL::to('assets/images/bank-images/KK.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/KK.jpg') }}">
                                                    Kiatnakin Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="ACL" data-value="070" data-image="{{ URL::to('assets/images/bank-images/ACL.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/ACL.jpg') }}">
                                                    ACL (ACLEDA) Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="TCRB" data-value="071" data-image="{{ URL::to('assets/images/bank-images/TCRB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/TCRB.png') }}">
                                                    Thai Credit Retail Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="LHBANK" data-value="073" data-image="{{ URL::to('assets/images/bank-images/LHBANK.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('assets/images/bank-images/LHBANK.jpg') }}">
                                                    Land and House Bank
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <input name="bank_code_character" id="bank_code_character" required readonly type="hidden">
                            <input name="bank_code" id="bank_code" required readonly type="hidden">
                            <div class="row mb-4">
                                <label for="customer_name" class="col-md-4 form-label">Account Name</label>
                                <div class="col-md-8">
								<input  class="form-control" required name="customer_name" placeholder="Enter Bank account name" type="text">
                                </div>
                            </div>
                            <div class="row mb-4">
								<label for="customer_account_number" class="col-md-4 form-label">Account Number</label>
								<div class="col-md-8">
									<input class="form-control" required name="customer_account_number" id="customer_account_number" placeholder="Enter Bank Account Number" type="text">
								</div>
							</div>
                             <!-- Spinner -->
                            <div class="spinner-container">
                                <img src="https://i.gifer.com/ZZ5H.gif" alt="Loading..."> <!-- Replace with your spinner image URL -->
                            </div>
                            <div class="text-center">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-block">Payout Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
