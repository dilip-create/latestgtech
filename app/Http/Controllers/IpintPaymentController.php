<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GatewayAccount;
use App\Models\GatewayChannel;
use App\Models\GatewayChannelParameter;
use App\Models\GatewayConfigurationMerchant;
use App\Models\DepositTransaction;
use App\Models\Merchant;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Session;

class IpintPaymentController extends Controller
{
    public function ipintDepositform(Request $request)
    {
        return view('payment-form.ipint.ipint-form');
    }

    public function ipintCheckout(Request $request)
    {
        $validatedData = $request->validate([
            'referenceId' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'required',
            'amount' => 'required',
        ]);
        // fetching gateway details START
        $res = RichPayController::getGatewayParameters($request->merchant_code, $request->channel_id);
        // fetching gateway details END
        if($res == 'Invalid Merchant!' || $res == 'Merchant is Disabled!' || $res == 'Invalid Channel!' || $res == 'Channel is Disabled!' || $res == 'Gateway is Disabled!' || $res == 'Gateway not configured for this Merchant!' || $res == 'Gateway configuration is Disabled for this Merchant!' || $res == 'Parameter not set!'){
             echo "<pre>";  print_r($res); die;
        }
        // echo "<pre>";  print_r($res); die;
        $client_ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
        $cleanAmount = str_replace(",", "", $request->amount);
        $frtransaction = RichPayController::generateUniqueCode();
        $apiSecret =  $res['parameters']['apiSecret']; 
        // Call Curl API code START
        $postData = [
           'client_email_id' => $request->customer_email,
            'amount' => $request->amount,
            'client_preferred_fiat_currency' => $request->Currency,
            'merchant_id' => $res['parameters']['merchant_id'],
            'merchant_website' => url('ipint/deposit/gatewayResponse'), 
            'invoice_callback_url' => url('api/ipintDeposit/WebhookNotifiication'),
        ];
        $response = Http::withHeaders([
            'apikey' => $res['parameters']['apiKey'],
            'Content-Type' => 'application/json',
        ])->post($res['parameters']['api_url'], $postData);

        $result = $response->json();
        //   echo "<pre>";  print_r($result); die;
          // Redirect to the payment link
        if (!empty($result['payment_process_url'])) {
                //Insert data into DB
                // for speedpay deposit charge START
                if(!empty($cleanAmount)){
                    $percentage = $res['parameters']['percentage_charge'];     // Deposit Charge for RichPay
                    $totalWidth = $cleanAmount;
                    $mdr_fee_amount = ($percentage / 100) * $totalWidth;
                    $net_amount= $totalWidth-$mdr_fee_amount;
                }
                // for speedpay deposit charge END
                $addRecord = [
                    'agent_id' => $res['merchantdata']['agent_id'],
                    'merchant_id' => $res['merchantdata']['id'],
                    'merchant_code' => $request->merchant_code,
                    'reference_id' => $request->referenceId,
                    'systemgenerated_TransId' => $frtransaction,
                    'gateway_TransId' => $result['session_id'] ?? '',
                    'callback_url' => $request->callback_url,
                    'amount' => $cleanAmount,
                    'Currency' => $request->Currency,
                    // 'bank_account_name' => $request->bank_account_name ?? $request->customer_name,
                    // 'bank_code' => $request->bank_code_character ?? $request->bank_code,
                    // 'bank_account_number' => $request->customer_account_number,
                    'payment_channel' => $res['channel']['id'] ?? '',
                    'payment_method' => $res['gateway_account']['payment_method'] ?? 'QR Payment',
                    'request_data' => json_encode($postData),
                    'gateway_name' => $res['gateway_account']['gateway_name'],
                    'customer_name' => $request->customer_name ?? $request->bank_account_name,
                    'customer_email' => $request->customer_email,
                    'payin_arr' => json_encode($result),
                    'receipt_url' => $result['payment_process_url'],
                    'ip_address' => $client_ip,
                    'net_amount' => $net_amount ?? '',
                    'mdr_fee_amount' => $mdr_fee_amount ?? '',
                ];
                DepositTransaction::create($addRecord);
                return redirect($result['payment_process_url']);
        } else {
                $addRecord = [
                    'agent_id' => $res['merchantdata']['agent_id'],
                    'merchant_id' => $res['merchantdata']['id'],
                    'merchant_code' => $request->merchant_code,
                    'reference_id' => $request->referenceId,
                    'systemgenerated_TransId' => $frtransaction,
                    'gateway_TransId' => $result['session_id'] ?? '',
                    'callback_url' => $request->callback_url,
                    'amount' => $cleanAmount,
                    'Currency' => $request->Currency,
                    'payment_channel' => $res['channel']['id'] ?? '',
                    'payment_method' => $res['gateway_account']['payment_method'] ?? 'QR Payment',
                    'request_data' => json_encode($postData),
                    'gateway_name' => $res['gateway_account']['gateway_name'],
                    'customer_name' => $request->customer_name ?? $request->bank_account_name,
                    'customer_email' => $request->customer_email,
                    'payin_arr' => json_encode($result),
                    'receipt_url' => $result['payment_process_url'] ?? '',
                    'ip_address' => $client_ip,
                    'net_amount' => $net_amount ?? '',
                    'mdr_fee_amount' => $mdr_fee_amount ?? '',
                    'payment_status' => 'failed',
                ];
                DepositTransaction::create($addRecord);
                echo "Unexpected Response"; echo "<pre>"; print_r($result); die;
        }

    }

    public function ipintDepositGatewayResponse(Request $request)
    {
        $response = $request->all();
        // echo "<pre>"; print_r($response); 
        $invoiceId = $response['invoice_id'];
        //Generate Signature START
        $nonce = time() * 1000;
        $apiPath = "/invoice?id={$invoiceId}";
        $apiSecret = '2TLcHzh13meEXwX1eruGVCiKoNVF4bRT72QhXc5d1hyq5EdcwPzsbNCgPquyZ6JZo';
        $sig = "/api/{$nonce}{$apiPath}";
        $signature = hash_hmac('sha384', $sig, $apiSecret, false);
         //Generate Signature END
        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'apikey' => '2F4yX41QTva26mi5p5SsaqeLo4idFrye4HpqDcFNtuL4irD29uxiA39M1gsC3wFwU',
            'signature' => $signature,
            'nonce' => $nonce,
        ])->get("https://api.ipint.io:8003/invoice", [
            'id' => $invoiceId
        ]);
        $result = $response->json();
        // echo "<pre>"; print_r($result); die;
        if ($response->successful() && isset($result['data'])) {
            $Transactionid = $result['data']['invoice_id'];
            $orderstatus = match ($result['data']['transaction_status'] ?? null) {
                'COMPLETED' => 'success',
                'CHECKING' => 'pending',
                'PROCESSING' =>  'processing',
                default => 'failed',
            };
            $receivedCryptoAmount = !empty($result['data']['received_crypto_amount']) ? $result['data']['received_crypto_amount'] : $result['data']['invoice_crypto_amount'];
            $cryptoCurrency = $result['data']['transaction_crypto'];
                $updateData = [
                    'amount' => $receivedCryptoAmount,
                    'Currency' => $cryptoCurrency,
                    'payment_status' => $orderstatus,
                    'response_data' => json_encode($result)
                ];
                DepositTransaction::where('gateway_TransId', $Transactionid)->update($updateData);
                $paymentDetail = DepositTransaction::where('gateway_TransId', $Transactionid)->first();
                $callbackUrl = $paymentDetail->callback_url;
                $postData = [
                    'merchant_code' => $paymentDetail->merchant_code,
                    'referenceId' => $paymentDetail->reference_id,
                    'transaction_id' => $paymentDetail->systemgenerated_TransId,
                    'amount' => $paymentDetail->amount,
                    'Currency' => $paymentDetail->Currency,
                    'customer_name' => $paymentDetail->customer_name,
                    'payment_status' => $paymentDetail->payment_status,
                    'created_at' => $paymentDetail->created_at,
                ];
                return view('payment.payment_status', compact('request', 'postData', 'callbackUrl'));
            
        }else{
            echo "Unexpected Response"; echo "<pre>"; print_r($result); die;
        }

    }

    public function ipintdepositResponse(Request $request)
    {
        $data = $request->all();
        // echo "Transaction Information as follows" . '<br/>' .
        //     "Merchant_code : " . $data['merchant_code'] . '<br/>' .
        //     "ReferenceId : " . $data['referenceId'] . '<br/>' .
        //     "TransactionId : " . $data['transaction_id'] . '<br/>' .
        //     "Type : Crypto Deposit" .'<br/>' .
        //     "Currency : " . $data['Currency'] . '<br/>' .
        //     "Amount : " . $data['amount'] . '<br/>' .
        //     "customer_name : " . $data['customer_name'] . '<br/>' .
        //     "Datetime : " . $data['created_at'] . '<br/>' .
        //     "Status : " . $data['payment_status'];
        return view('payment-form.r2p.deposit-response-page', compact('data'));
         
    }

    public function ipintDepositWebhookNotifiication(Request $request)
    {
       // { "invoice_id": 'invoice id', "status": "COMPLETED" }     //FAILED/COMPLETED 
        // Decode the JSON payload automatically
        $results = $request->json()->all();
        if(!empty($results)) {
            // Extract data
            $transactionId = $results['invoice_id'] ?? null;
            $orderStatus = match ($results['status'] ?? '') {
                'COMPLETED' => 'success',
                'FAILED' => 'failed',
                default => 'failed',
            };
            $updateData = [
                'payment_status' => $orderStatus,
                'response_data' => json_encode($results),
            ];
            DepositTransaction::where('gateway_TransId', $transactionId)->update($updateData);
            echo "Transaction updated successfully!";
            //Call webhook API START
            $paymentDetail = DepositTransaction::where('gateway_TransId', $transactionId)->first();
            $callbackUrl = $paymentDetail->callback_url;
            $postData = [
                    'merchant_code' => $paymentDetail->merchant_code,
                    'referenceId' => $paymentDetail->reference_id,
                    'transaction_id' => $paymentDetail->systemgenerated_TransId,
                    'amount' => $paymentDetail->amount,
                    'Currency' => $paymentDetail->Currency,
                    'customer_name' => $paymentDetail->customer_name,
                    'payment_status' => $paymentDetail->payment_status,
                    'created_at' => $paymentDetail->created_at,
            ];
            // echo "<pre>";  print_r($postData); die;
            try {
                if ($paymentDetail->callback_url != null) {
                    $response = Http::post($paymentDetail->callback_url, $postData);
                    echo $response->body(); die;
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to call webhook','message' => $e->getMessage()], 500);
            }
             //Call webhook API START

        }else{
            return response()->json(['error' => 'Data Not Found or Invalid Request!'], 400);
        }



    }

}
