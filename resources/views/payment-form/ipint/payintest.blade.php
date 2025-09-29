<?php
$referenceNo = "GZTRN" . time() . (function ($length = 3) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
})();
// $apiUrl = "http://127.0.0.1:8000/api/ip/checkout";
$apiUrl = "https://payment.zaffranpay.com/api/ip/checkout";
$data = [
    'merchant_code' => $_GET['merchant_code'],
    'channel_id' => '4',
    'referenceId' => $referenceNo, 
    // 'callback_url' => 'http://127.0.0.1:8000/api/ip/depositResponse',
    'callback_url' => 'https://payment.zaffranpay.com/api/ip/depositResponse',
    'Currency' =>  $_GET['Currency'], 
    'amount' => $_GET['amount'],   
    'customer_email' => 'dk@gmail.com', 
    'customer_name' => 'dk John Doe', 
];
$fullUrl = $apiUrl . '?' . http_build_query($data);
?>
<script>
    window.location.href = '<?php echo $fullUrl; ?>';     
</script>

