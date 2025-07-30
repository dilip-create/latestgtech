<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DepositTransaction;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Session;

class RichPayController extends Controller
{
    // public function payinform(Request $request)
    // {
    //     return view('payment-form.r2p.payin-form');
    // }

    public function payin(Request $request)
    {
        $validatedData = $request->validate([
            'bank_code' => 'required',
            'bank_code_character' => 'required',
            'bank_account_name' => 'required',
            'customer_account_number' => 'required',
        ]);
        // echo "<pre>";  print_r($request->all()); die;

        $frtransaction = $this->generateUniqueCode();
        $client_ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);

        $secretKey =  $res['secretKey'] ?? 'Z0FBQUFBQm55WHJRYllhRGdjNXl5NjFvTDRLRHNhcElGamN3'; // Store secret key in .env file
        $orderId = $frtransaction; // Replace with actual Order ID
        $amount =  $request->amount; // Replace with actual Amount
        // Step 1: Concatenate in required format
        $signatureString = "{$secretKey}:{$orderId}:{$amount}";
        // Step 2: Encode using Base64
        $encodedSignature = base64_encode($signatureString);

        // Call Curl API code START
        $postData = [
            // 'UrlFront' => url('s2p/payinResponse'), 
            'order_id' => $frtransaction,
            'amount' => $request->amount,
            'ref_account' => $request->customer_account_number,
            'ref_bank_code' => $request->bank_code,
            'ref_name_th' => $request->customer_name,
            'ref_name_en' => $request->customer_name,
            'ref_user_id' => '',
            'ref1' => '',
            'ref2' => '',
            'callback_url' => url('api/r2pDepositNotifiication'),
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0eXBlIjoiT1NNTyIsInNpZ25hdHVyZSI6ImNTMUNYMlZ6ZEU0MkxWUjNiMnRLZDFNeE1qQmhXRUpTZWpSTlFtOUVSVlpzWTFGblRXeHpNR1ZGVmtGRFoyNXdOSGxrTW1adVMyaFlTemxLTkRFeGFIa3phV3hwYjJVdE1VOXRlblYyY1daak16TXhVVkpIYVd0d09XeHJZV2xPVEhKVVRuZzNhV3cxVHpaMVpVNDVTMkZ0T0VoZlZraFhWRk56WW1GWGJEUkZUbEJTYXpWcVdrcHhNRXhuVkZabWN6bEJQUT09IiwiaWRlbnRpZmllciI6IlowRkJRVUZCUW01NVdISlJUa1JyZUdaVFRIcFdhMk41ZURaM2NVSm1SMmhCWkU5TU5scGxkR1E1TlV0bWNuaFZjQzExV213eFRFZGFSRXRTTUhKMFdqVm9iRGhrTTBwd2RFNU1aa1Y0VGtGYU1DMXphVmgzTlRZd1gzTXRhazVRWnpVeFMxTm5kVXBhWTBwSk0xbHdUVGRDU2tGRk5HODkifQ.gvm5-f2jGiJyDXYlaRsgLgscgQv3YS2zV7IHE4ZgWwg', // Ensure proper concatenation
            'x-api-key' => $res['apiKey'] ?? 'c48beec83f740331c0ff58', // Correct usage of array key
            'x-signature' => $encodedSignature, // No change needed
        ])->post($res['api_url'] ?? 'https://service.richpay.io/api/v1/client/create_deposit', $postData);
        $jsonData = $response->json();
        // echo "<pre>";  print_r($jsonData); die;
        // Redirect to the payment link
        if (isset($jsonData['qr_image_link'])) {
            //Insert data into DB
             // for speedpay deposit charge START
            if(!empty($request->amount)){
                $percentage = 1.35;     // Deposit Charge for RichPay
                $totalWidth = $request->amount;
                $mdr_fee_amount = ($percentage / 100) * $totalWidth;
                $net_amount= $totalWidth-$mdr_fee_amount;
            }
            // for speedpay deposit charge END
            $addRecord = [
                'agent_id' => $merchantData->agent_id ?? '1',
                'merchant_id' => $merchantData->id ?? '1',
                'merchant_code' => $request->merchant_code,
                'reference_id' => $request->referenceId,
                'systemgenerated_TransId' => $frtransaction,
                'gateway_TransId' => $jsonData['ref_id'],
                'callback_url' => $request->callback_url,
                'amount' => $request->amount,
                'Currency' => $request->Currency,
                'product_id' => $request->product_id,
                'bank_account_name' => $request->bank_account_name ?? $request->customer_name,
                'bank_code' => $request->bank_code_character ?? $request->bank_code,
                'bank_account_number' => $request->customer_account_number,
                'payment_channel' => $gatewayPaymentChannel->id ?? '',
                'payment_method' => $paymentMethod->method_name ?? 'QR Payment',
                // 'request_data' => json_encode($res),
                'gateway_name' => 'RichPay',
                'customer_name' => $request->customer_name ?? $request->bank_account_name,
                'customer_email' => $request->customer_email,
                'payin_arr' => json_encode($jsonData),
                'receipt_url' => $jsonData['qr_image_link'],
                'ip_address' => $client_ip,
                'net_amount' => $net_amount ?? '',
                'mdr_fee_amount' => $mdr_fee_amount ?? '',
            ];
            //   echo "<pre>";  print_r($addRecord); die;
            DepositTransaction::create($addRecord);
            // sleep(20);
            return redirect(url('r2pPaymentPage/'.base64_encode($frtransaction)));
        }else{
            return back()->with('error', 'Payment link not found.');
        }

    }

    public function paymentPage(Request $request, $frtransaction)
    {
        $RefID = base64_decode($frtransaction);
        $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $RefID)->first();
          
            $data = [
                'merchant_code' => $paymentDetail->merchant_code,
                'referenceId' => $paymentDetail->reference_id,
                'transaction_id' => $paymentDetail->systemgenerated_TransId,
                'amount' => $paymentDetail->amount,
                'Currency' => $paymentDetail->Currency,
                'customer_name' => $paymentDetail->customer_name,
                'bank_account_name' => $paymentDetail->bank_account_name,
                'bank_code' => $paymentDetail->bank_code,
                'bank_account_number' => $paymentDetail->bank_account_number,
                'receipt_url' => $paymentDetail->receipt_url,
                'payment_status' => $paymentDetail->payment_status,
                'created_at' => $paymentDetail->created_at,
            ];
                // echo "<pre>";  print_r($data); die;
        return view('payment-form.r2p.paymentPage', compact('data'));
    }

    public function paymentProcessingPage(Request $request, $frtransaction)
    {
        $RefID = base64_decode($frtransaction);
        $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $RefID)->first();
            $data = [
                'merchant_code' => $paymentDetail->merchant_code,
                'referenceId' => $paymentDetail->reference_id,
                'transaction_id' => $paymentDetail->systemgenerated_TransId,
                'amount' => $paymentDetail->amount,
                'Currency' => $paymentDetail->Currency,
                'customer_name' => $paymentDetail->customer_name,
                'bank_account_name' => $paymentDetail->bank_account_name,
                'bank_code' => $paymentDetail->bank_code,
                'bank_account_number' => $paymentDetail->bank_account_number,
                'receipt_url' => $paymentDetail->receipt_url,
                'payment_status' => $paymentDetail->payment_status,
                'created_at' => $paymentDetail->created_at,
            ];
            // echo "<pre>";  print_r($data); die;
        return view('payment-form.r2p.paymentProcessingPage', compact('data'));
    }

    public function payinResponse(Request $request, $frtransaction)
    {
        $systemgenerated_TransId = base64_decode($frtransaction);
        $updateData = [
            'payment_status' => 'processing',
            // 'response_data' => json_encode($jsonData),
        ];
        DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->update($updateData);
        $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->first();
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
    }

    public function r2pPayinCallbackURL(Request $request)
    {
        $data = $request->all();
        // echo "Transaction Information as follows" . '<br/>' .
        //     "Merchant : " . $data['merchant_code'] . '<br/>' .
        //     "ReferenceId : " . $data['referenceId'] . '<br/>' .
        //     "TransactionId : " . $data['transaction_id'] . '<br/>' .
        //     "Type : Deposit" .'<br/>' .
        //     "Currency : " . $data['Currency'] . '<br/>' .
        //     "Amount : " . $data['amount'] . '<br/>' .
        //     "customer_name : " . $data['customer_name'] . '<br/>' .
        //     "Datetime : " . $data['created_at'] . '<br/>' .
        //     "Status : " . $data['payment_status'];
        return view('payment-form.r2p.deposit-response-page', compact('data'));
    }

    public function r2pDepositNotifiication(Request $request)
    {
        // echo "<pre>";  print_r($request->all());
        // $results = '{
        //   "type": "DEPOSIT",
        //   "status": "SUCCESS",
        //   "status_des": "",
        //   "amount": 0,
        //   "txn_ref_id": "",
        //   "txn_ref_order_id": "",
        //   "txn_ref_bank_code": "",
        //   "txn_ref_bank_acc_no": "",
        //   "txn_ref_bank_acc_name": "",
        //   "txn_ref_user_id": "",
        //   "txn_ref1": "",
        //   "txn_ref2": "",
        //   "txn_timestamp": "1970-01-01T00:00:00",
        //   "stm_timestamp": "1970-01-01T00:00:00",
        //   "stm_bank_code": "",
        //   "stm_bank_acc_no": "",
        //   "stm_bank_acc_name": "",
        //   "stm_desc": "",
        //   "stm_ref_id": ""
        // }';
        $data = $request->json()->all(); // Get JSON data from request
        if (!empty($data)) {
             $orderStatus = match ($data['status'] ?? '') {
                'SUCCESS' => 'success',
                'AUTO_SUCCESS' => 'success',
                'PROCESSING' => 'processing',
                'Failed' => 'failed',
                default => 'not confirm',
            };
            $RefID = $data['txn_ref_order_id'];
            sleep(50);
            $updateData = [
                'payment_status' => $orderStatus ?? $data['status'],
                'response_data' => json_encode($data),
            ];
            // echo "<pre>";  print_r($updateData); die;
            DepositTransaction::where('systemgenerated_TransId', $RefID)->update($updateData);
            echo "Transaction updated successfully!";
            //Call webhook API START
            $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $RefID)->first();
            $callbackUrl = $paymentDetail->callback_url;
            $postData = [
                'merchant_code' => $paymentDetail->merchant_code,
                'referenceId' => $paymentDetail->transaction_id,
                'transaction_id' => $paymentDetail->systemgenerated_TransId,
                'amount' => $paymentDetail->amount,
                'Currency' => $paymentDetail->Currency,
                'customer_name' => $paymentDetail->customer_name,
                'payment_status' => $paymentDetail->payment_status,
                'created_at' => $paymentDetail->created_at,
            ];
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

    

    public function generateUniqueCode()
    {
        $mytime = Carbon::now();
        $currentDateTime = str_replace(' ', '', $mytime->parse($mytime->toDateTimeString())->format('Ymd His'));
        $systemgenerated_TransId = $currentDateTime.random_int(1000, 9999);
        return 'TR'.$systemgenerated_TransId;
    }
}
