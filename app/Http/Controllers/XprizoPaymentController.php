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

use App\Events\DepositCreated;
use App\Models\TransactionNotification;

class XprizoPaymentController extends Controller
{
    public function xpzDepositform(Request $request)
    {
        return view('payment-form.xpz.deposit');
    }

    public function xpzDepositApifun(Request $request)
    {
        $validatedData = $request->validate([
            'referenceId' => 'required',
            'Currency' => 'required',
            'amount' => 'required',
            'customer_name' => 'required',
            'card_number' => 'required',
            'cvv' => 'required',
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
        $accountId =  $res['parameters']['accountId']; 

        // Call Curl API code START
        $expiration = $request->expiration;
        if(empty($expiration)){
            $expiryMonth =$request->expiryMonth;
            $expiryYear =$request->expiryYear;
        }else{
            list($expiryMonth, $expiryYear) = explode('/', $expiration);
        }
         $postData = [
            'description' => 'Success',
            'reference' => $frtransaction,
            'amount' => $request->amount,
            'currencyCode' => $request->Currency,
            'accountId' => $res['parameters']['accountId'],
            // 'transferAccountId' => $res['parameters']['transferAccountId'],
            // 'customer' => $request->customer_name,
            'customerData' => [
                'name' => $request->customer_name,
                'email' => $request->customer_email ?? 'default@example.com', // Ensure email is available
                'mobile' => '+855 69861408', 
                // 'birthDate' => '2025-02-03T10:21:01.871Z', 
                // 'ipAddress' => request()->ip(), // Fetch user's IP dynamically
                // 'address' => [
                //     'address' => 'poipet',
                //     'countryCode' => 'KHM',
                //     'street' => 'poipet',
                //     'city' => 'poipet',
                //     'stateProvinceRegion' => 'Battambang Province',
                //     'zipPostalCode' => '273154'
                // ],
                // 'device' => [
                //     'width' => $request->device_width ?? 'unknown',
                //     'height' => $request->device_height ?? 'unknown',
                //     'userAgent' => $request->header('User-Agent') ?? 'unknown',
                //     'colorDepth' => $request->colorDepth ?? 'unknown'
                // ]
            ],
            'creditCard' => [
                'name' => $request->customer_name,
                'number' => $request->card_number,
                'expiryMonth' => $expiryMonth ?? $request->expiryMonth,
                'expiryYear' => '20'. $expiryYear ?? $request->expiryYear,
                //  'expiryYear' => $expiryYear ?? $request->expiryYear,
                'cvv' => $request->cvv,
            ],
            'routingCode' => $res['parameters']['routingCode'],
            'redirect' => url('xpz/deposit/gatewayResponse'), 
        ];

        $response = Http::withHeaders([
            'x-api-version' => '1.0',
            'x-api-key' => $res['parameters']['apiKey'],
            'Accept' => 'text/plain',
            'Content-Type' => 'application/json',
        ])->post($res['parameters']['api_url'], $postData);

        $result = $response->json();
        // echo "<pre>"; print_r($postData); print_r($result); die;
         // for Xprixo deposit charge START
        if(!empty($cleanAmount)){
            $percentage = $res['parameters']['percentage_charge'];     // Deposit Charge for RichPay
            $totalWidth = $cleanAmount;
            $mdr_fee_amount = ($percentage / 100) * $totalWidth;
            $net_amount= $totalWidth-$mdr_fee_amount;
        }
        // for Xprixo deposit charge END

        if ( isset($result)  &&  $result['status'] == 'Redirect' ) {
                //Insert data into DB
                $addRecord = [
                    'agent_id' => $res['merchantdata']['agent_id'],
                    'merchant_id' => $res['merchantdata']['id'],
                    'merchant_code' => $request->merchant_code,
                    'reference_id' => $request->referenceId,
                    'systemgenerated_TransId' => $frtransaction,
                    // 'gateway_TransId' => $result['session_id'] ?? '',
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
                    // 'customer_email' => $request->customer_email,
                    'payin_arr' => json_encode($result),
                    'receipt_url' => $result['value'],
                    'ip_address' => $client_ip,
                    'net_amount' => $net_amount ?? '',
                    'mdr_fee_amount' => $mdr_fee_amount ?? '',
                ];
                DepositTransaction::create($addRecord);

                
                // Broadcast the event Notification code START
                $data = [
                    'type' => 'Deposit',
                    'transaction_id' => $frtransaction,
                    'amount' => $request->amount,
                    'Currency' => $request->Currency,
                    'status' => 'pending',
                    'msg' => 'New Deposit Transaction Created!',
                ];
                event(new DepositCreated($data));   
                // Broadcast the event Notification code END
                // Insert data in Notification table Code START
                $merchant=Merchant::where('merchant_code', $request->merchant_code)->first();
                $addNotificationRecord = [
                    'notifiable_type' => 'Deposit',
                    'agent_id' => $merchant->agent_id,
                    'merchant_id' => $merchant->id,
                    'data' => json_encode($data,true),
                    'msg' => 'New Deposit Transaction Created!',
                ];
                TransactionNotification::create($addNotificationRecord);
                // Insert data in Notification table Code END

                return redirect($result['value']);
        } else {
                $addRecord = [
                    'agent_id' => $res['merchantdata']['agent_id'],
                    'merchant_id' => $res['merchantdata']['id'],
                    'merchant_code' => $request->merchant_code,
                    'reference_id' => $request->referenceId,
                    'systemgenerated_TransId' => $frtransaction,
                    // 'gateway_TransId' => $result['session_id'] ?? '',
                    'callback_url' => $request->callback_url,
                    'amount' => $cleanAmount,
                    'Currency' => $request->Currency,
                    'payment_channel' => $res['channel']['id'] ?? '',
                    'payment_method' => $res['gateway_account']['payment_method'] ?? 'QR Payment',
                    'request_data' => json_encode($postData),
                    'gateway_name' => $res['gateway_account']['gateway_name'],
                    'customer_name' => $request->customer_name ?? $request->bank_account_name,
                    // 'customer_email' => $request->customer_email,
                    'payin_arr' => json_encode($result),
                    'receipt_url' => $result['message'] ?? '',
                    'ip_address' => $client_ip,
                    'net_amount' => $net_amount ?? '',
                    'mdr_fee_amount' => $mdr_fee_amount ?? '',
                    'payment_status' => 'failed',
                ];
                DepositTransaction::create($addRecord);
                echo "Unexpected Response"; echo "<pre>"; print_r($result); die;
        }

    }


    public function xpzDepositResponse(Request $request)
    {
        $data = $request->all();
        // echo "Transaction Information as follows" . '<br/>' .
        //     "Merchant_code : " . $data['merchant_code'] . '<br/>' .
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
}
