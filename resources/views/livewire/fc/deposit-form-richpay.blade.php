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

      /* Custom dropdown for select Bank START */
      .custom-dropdown {
            position: relative;
            width: 100%;
            font-family: Arial, sans-serif;

            height: 3rem !important;
            border: 2px solid gray;
            border-radius: 0.5rem;
        }
        .dropdown-selected {
            height: 2.80rem !important;
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
 <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-7">
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h1 class="text-muted text-uppercase py-3"><b>POIPET RESORT</b></h1>
                                    </div>
                                    {{-- <form role="form" action="{{ route('apiroute.r2p.payin') }}" method="GET" id="paymentForm" class="parsley-examples" data-parsley-validate novalidate> --}}
                                    @csrf
                                        <input type="hidden" name="merchant_code" value="FCmerchant001">
                                        <input type="hidden" name="product_id" value="27">    {{--for local 25 for live 27 --}}
                                        {{-- <input type="hidden" name="callback_url" value="{{ route('apiroute.r2pPayincallbackURL') }}"> --}}
                                        <input type="hidden" name="amount" value="{{ $amount ?? '' }}">
                                        <input type="hidden" name="Currency" value="THB">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Enter Customer Name</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="customer_name" value="{{ $customer_name ?? '' }}" required readonly type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Invoice Number</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" name="referenceId" value="{{ $invoice_number ?? '' }}" required readonly type="text">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Bank Name</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                 <div class="custom-dropdown" id="bankDropdown">
                                            <div class="dropdown-selected" onclick="toggleDropdown()">
                                                <div style="display: flex; align-items: center;">
                                                    <img src="{{ URL::to('newassets/images/bank-images/dummy.png') }}" id="selectedImg">
                                                    <span id="selectedText">Select Bank</span>
                                                </div>
                                                <span class="arrow" id="arrow">&#9662;</span> <!-- Downward arrow -->
                                            </div>
                                            <div class="dropdown-list" id="dropdownList">
                                                <div class="dropdown-item" data-symbol="BBL" data-value="002" data-image="{{ URL::to('newassets/images/bank-images/BBL.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/BBL.png') }}">
                                                    Bangkok Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KBANK" data-value="004" data-image="{{ URL::to('newassets/images/bank-images/KBANK.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/KBANK.png') }}">
                                                    Kasikorn Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KTB" data-value="006" data-image="{{ URL::to('newassets/images/bank-images/KTB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/KTB.png') }}">
                                                    Krungthai Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="TMB" data-value="011" data-image="{{ URL::to('newassets/images/bank-images/TMB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/TMB.png') }}">
                                                    TMB Thanachart bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="SCB" data-value="014" data-value="" data-image="{{ URL::to('newassets/images/bank-images/SCB.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/SCB.jpg') }}" class="img-fluid rounded-circle" alt="">
                                                    Siam Commercial Bank
                                                </div>
                                                
                                                <div class="dropdown-item" data-symbol="CITI N.A" data-value="017" data-value="" data-image="{{ URL::to('newassets/images/bank-images/CITI.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/CITI.jpg') }}" class="img-fluid rounded-circle" alt="">
                                                    Citibank N.A.
                                                </div>
                                                <div class="dropdown-item" data-symbol="SCBT" data-value="020" data-value="" data-image="{{ URL::to('newassets/images/bank-images/SCBT.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/SCBT.png') }}" class="img-fluid rounded-circle" alt="">
                                                    Standard Chartered Bank (Thailand)
                                                </div>
                                                <div class="dropdown-item" data-symbol="CIMB" data-value="022" data-image="{{ URL::to('newassets/images/bank-images/CIMB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/CIMB.png') }}">
                                                    CIMB Thai bank
                                                </div>
                                                
                                                <div class="dropdown-item" data-symbol="UOB" data-value="024" data-image="{{ URL::to('newassets/images/bank-images/UOB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/UOB.png') }}">
                                                    UOB Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="BAY" data-value="025" data-image="{{ URL::to('newassets/images/bank-images/BAY.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/BAY.jpg') }}">
                                                    Bank of Ayudhya
                                                </div>
                                                <div class="dropdown-item" data-symbol="GOV" data-value="030" data-image="{{ URL::to('newassets/images/bank-images/GOV.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/GOV.jpg') }}">
                                                    Government Savings Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="GHB" data-value="033" data-image="{{ URL::to('newassets/images/bank-images/GHB.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/GHB.jpg') }}">
                                                    Government Housing Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="AGRI" data-value="034" data-image="{{ URL::to('newassets/images/bank-images/AGRI.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/AGRI.png') }}">
                                                    Bank for Agriculture and Agricultural Cooperatives
                                                </div>
                                                <div class="dropdown-item" data-symbol="ISBT" data-value="066" data-image="{{ URL::to('newassets/images/bank-images/ISBT.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/ISBT.jpg') }}">
                                                    Islamic Bank of Thailand
                                                </div>
                                                <div class="dropdown-item" data-symbol="TISCO" data-value="067" data-image="{{ URL::to('newassets/images/bank-images/TISCO.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/TISCO.png') }}">
                                                    TISCO Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="KK" data-value="069" data-image="{{ URL::to('newassets/images/bank-images/KK.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/KK.jpg') }}">
                                                    Kiatnakin Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="ACL" data-value="070" data-image="{{ URL::to('newassets/images/bank-images/ACL.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/ACL.jpg') }}">
                                                    ACL (ACLEDA) Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="TCRB" data-value="071" data-image="{{ URL::to('newassets/images/bank-images/TCRB.png') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/TCRB.png') }}">
                                                    Thai Credit Retail Bank
                                                </div>
                                                <div class="dropdown-item" data-symbol="LHBANK" data-value="073" data-image="{{ URL::to('newassets/images/bank-images/LHBANK.jpg') }}" onclick="selectBank(this)">
                                                    <img src="{{ URL::to('newassets/images/bank-images/LHBANK.jpg') }}">
                                                    Land and House Bank
                                                </div>  
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                        
                                        <input name="bank_code_character" id="bank_code_character" required readonly type="hidden">
                                        <input name="bank_code" id="bank_code" required readonly type="hidden">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Account Name</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input list="browsers" id="browser" class="form-control" required name="bank_account_name" placeholder="Enter Bank account name" type="text">
                                                <datalist id="browsers">
                                                    <option value="{{ $customer_name ?? '' }}">
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-md-4 col-form-label"><strong>Account Number</strong><span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <input class="form-control" required name="customer_account_number" id="customer_account_number" placeholder="Enter Bank Account Number" type="text">
                                            </div>
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


