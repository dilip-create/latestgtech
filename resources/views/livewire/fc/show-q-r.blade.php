<div>
<style>
    .qr-container {
        text-align: center;
        margin-top: 50px;
    }
    .qr-btn {
        display: block;
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
    }
    .qr-btn:hover {
        background-color: #45a049;
    }
</style>
        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center pt-5">
                    <div class="col-md-8 col-lg-6 col-xl-6 pt-5"><br/><br/>
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="my-3">
                                            <a href="#">
                                                <span><img src="{{ URL::to('newassets/images/logo-Gtech.png') }}" alt="" height="28"></span>
                                            </a>
                                        </div>
                                    </div>
                                        <div class="qr-container">
                                        <!-- Display QR Code as SVG -->
                                        {!! QrCode::size(300)->generate($this->record->qr_img_url) !!}
                                        <center><br/>
                                            <a href="{{$this->record->qr_img_url}}" target="_blank"><p><b>{{ $this->record->invoice_number }}-{{$this->record->amount}}-{{$this->record->Currency}}.png</b></p></a>
                                            
                                            <button class="btn btn-success waves-effect waves-light" id="downloadQR" 
                                                    data-invoice-number="{{ $this->record->invoice_number }}" 
                                                    data-amount="{{ $this->record->amount }}"
                                                    data-Currency="{{ $this->record->Currency }}">
                                                <i class="fa fa-download"></i> Download QR Code
                                            </button>
                                        </center><br/>
                                        </div>
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
        document.getElementById('downloadQR').addEventListener('click', function () {
            var qrCodeSvg = document.querySelector('svg');
            var svgData = new XMLSerializer().serializeToString(qrCodeSvg);
            var svgBlob = new Blob([svgData], { type: 'image/svg+xml' });
            var svgUrl = URL.createObjectURL(svgBlob);
            var img = new Image();
            img.src = svgUrl;
    
            // Get dynamic name values
            var invoiceNumber = this.getAttribute('data-invoice-number');
            var amount = this.getAttribute('data-amount');
            var Currency = this.getAttribute('data-Currency');
    
            // Create a temporary canvas to draw the SVG
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            img.onload = function () {
                // Set the canvas size equal to the image size
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
    
                // Convert the canvas to PNG or JPEG format
                var imgData = canvas.toDataURL('image/png'); // Change 'image/png' to 'image/jpeg' for JPEG format
    
                // Create a download link
                var a = document.createElement('a');
                a.href = imgData;
                a.download = `${invoiceNumber}-${amount}-${Currency}.png`; // Dynamic file name
                a.click();
            };
        });
    </script>
</div>

