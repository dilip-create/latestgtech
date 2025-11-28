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
    //UPI DEPOSIT START
    public function xpzUPIdeposit(Request $request)
    {
        return view('payment-form.xpz.upi-deposit');
    }

    public function xpzUPIDepositfun(Request $request)
    {
        $validatedData = $request->validate([
            'referenceId' => 'required',
            'Currency' => 'required',
            'amount' => 'required',
            'customer_name' => 'required',
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
         $postData = [
            'description' => 'Success',
            'reference' => $frtransaction,
            'amount' => $request->amount,
            'currencyCode' => $request->Currency,
            'accountId' => $res['parameters']['accountId'],
            'customer' => $request->customer_name,
            // 'routingCode' => $res['parameters']['routingCode'],
            'redirect' => url('xpz/UPIdepositResponse/'.base64_encode($frtransaction).'/'.base64_encode($request->merchant_code).'/'.base64_encode($request->channel_id)), 
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
                    'gateway_TransId' => $result['key'] ?? '',
                    'callback_url' => $request->callback_url,
                    'amount' => $cleanAmount,
                    'Currency' => $request->Currency,
                    'payment_channel' => $res['channel']['id'] ?? '',
                    'payment_method' => $res['gateway_account']['payment_method'] ?? 'QR Payment',
                    'request_data' => json_encode($postData),
                    'gateway_name' => 'Xprizo UPI',
                    'customer_name' => $request->customer_name ?? $request->bank_account_name,
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
                    'callback_url' => $request->callback_url,
                    'amount' => $cleanAmount,
                    'Currency' => $request->Currency,
                    'payment_channel' => $res['channel']['id'] ?? '',
                    'payment_method' => $res['gateway_account']['payment_method'] ?? 'QR Payment',
                    'request_data' => json_encode($postData),
                    'gateway_name' => 'Xprizo UPI',
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

    public function TransactionStatusUPIfun( $frtransaction, $merchantCode, $channelId, )
    {

            $systemgenerated_TransId = base64_decode($frtransaction);
             // fetching gateway details START
            $res = RichPayController::getGatewayParameters(base64_decode($merchantCode), base64_decode($channelId));
            // fetching gateway details END
            if($res == 'Invalid Merchant!' || $res == 'Merchant is Disabled!' || $res == 'Invalid Channel!' || $res == 'Channel is Disabled!' || $res == 'Gateway is Disabled!' || $res == 'Gateway not configured for this Merchant!' || $res == 'Gateway configuration is Disabled for this Merchant!' || $res == 'Parameter not set!'){
                echo "<pre>";  print_r($res); die;
            }
            
            $api_url = $res['gateway_account']['website_url'] . 'api/Transaction/Status/' . $res['parameters']['accountId'] . '/?reference=' . $systemgenerated_TransId;
            // dd($api_url);
            $response = Http::withHeaders([
                'x-api-version' => '1.0',
                'x-api-key'     => $res['parameters']['apiKey'],
            ])->get($api_url);
            $result = $response->json();
            // echo "<pre>"; print_r($result); die;
           
                $orderstatus = match ($result['status'] ?? null) {
                    'Active' => 'success',
                    'Pending' => 'pending',
                    default => 'failed',
                };
     
                $updateData = [
                    'payment_status' => $orderstatus,
                    'receipt_url' => $result['value'],
                    'payin_arr' => json_encode($result)
                ];
                // echo "<pre>"; print_r($updateData); die;
                DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->update($updateData);
                $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->first();
                        // Broadcast the event Notification code START
                        $data = [
                            'type' => 'Transaction Updated',
                            'transaction_id' => $paymentDetail->systemgenerated_TransId,
                            'amount' => $paymentDetail->amount,
                            'Currency' => $paymentDetail->Currency,
                            'status' => $paymentDetail->payment_status,
                            'msg' => 'Transaction Status Updated!',
                        ];
                        event(new DepositCreated($data));   
                        // Broadcast the event Notification code END
                        // Insert data in Notification table Code START
                        $addNotificationRecord = [
                            'notifiable_type' => 'Transaction Updated',
                            'agent_id' => $paymentDetail->agent_id,
                            'merchant_id' => $paymentDetail->merchant_id,
                            'data' => json_encode($data,true),
                            'msg' => 'Transaction Status Updated!',
                        ];
                        TransactionNotification::create($addNotificationRecord);
                    // Insert data in Notification table Code END

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
                return view('payment.payment_status', compact( 'postData', 'callbackUrl'));
            
    }
    //UPI DEPOSIT END
    //CARD DEPOSIT START
    public function xpzDepositformUSD(Request $request)
    {
        return view('payment-form.xpz.deposit-USD');
    }

    public function xpzDepositformTHB(Request $request)
    {
        return view('payment-form.xpz.deposit-THB');
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
                // 'email' => $frtransaction.'@gmail.com', 
                // 'mobile' => '+855 ' . sprintf('%08d', mt_rand(0, 99999999)), 
                'email' => 'dilipkumargupta631@gmail.com', 
                'mobile' => '+85596861409', 
                // 'birthDate' => '2025-02-03T10:21:01.871Z', 
                // 'ipAddress' => request()->ip(), // Fetch user's IP dynamically
                'address' => [
                    'address' => 'poipet',
                    'countryCode' => 'KHM',
                    'street' => 'poipet',
                    'city' => 'poipet',
                    'stateProvinceRegion' => 'Battambang Province',
                    'zipPostalCode' => '273154'
                ],
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
        //  echo "<pre>"; print_r($postData);  die;
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
                    'gateway_TransId' => $result['key'] ?? '',
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

    public function xpzDepositGatewayResponse(Request $request)
    {
            $response = $request->all();
            $systemgenerated_TransId = $response['reference'] ?? null;
            $gateway_TransId = $response['key'] ?? null;
        
            $orderstatus = match ($response['status'] ?? null) {
                'Active' => 'success',
                'Pending' => 'pending',
                default => 'failed',
            };
     
                $updateData = [
                    'gateway_TransId' => $gateway_TransId,
                    'payment_status' => $orderstatus,
                    'payin_arr' => json_encode($response)
                ];
                DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->update($updateData);
                $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->first();
                        // Broadcast the event Notification code START
                        $data = [
                            'type' => 'Transaction Updated',
                            'transaction_id' => $paymentDetail->systemgenerated_TransId,
                            'amount' => $paymentDetail->amount,
                            'Currency' => $paymentDetail->Currency,
                            'status' => $paymentDetail->payment_status,
                            'msg' => 'Transaction Status Updated!',
                        ];
                        event(new DepositCreated($data));   
                        // Broadcast the event Notification code END
                        // Insert data in Notification table Code START
                        $addNotificationRecord = [
                            'notifiable_type' => 'Transaction Updated',
                            'agent_id' => $paymentDetail->agent_id,
                            'merchant_id' => $paymentDetail->merchant_id,
                            'data' => json_encode($data,true),
                            'msg' => 'Transaction Status Updated!',
                        ];
                        TransactionNotification::create($addNotificationRecord);
                    // Insert data in Notification table Code END

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
    //CARD DEPOSIT END

    // COMMON PART START
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

    public function xpzWebhookNotifiication(Request $request)
    {
        // {
        //     "statusType": 3,
        //     "status": "Rejected",  // New /Accepted/Cancelled
        //     "description": "Reason for rejection",
        //     "actionedById": 1,
        //     "affectedContactIds": [],
        //     "transaction": {
        //       "id": 0,
        //       "createdById": 2,
        //       "type": "UCD",
        //       "date": "2021-04-20T20:34:00.7606173+02:00",
        //       "reference": 234234234,
        //       "currencyCode": "USD",
        //       "amount": 100.00
        //     }
        // }
        // Decode the JSON payload automatically
        $results = $request->json()->all();
        if(!empty($results)) {
            $systemgenerated_TransId = $results['transaction']['reference'] ?? null;
            $orderStatus = match ($results['status'] ?? '') {
                'Active' => 'success',
                'Accepted' => 'success',
                'New' => 'processing',
                default => 'failed',
            };
            sleep(10);         // Simulate delay
                if(!empty($results['transaction']['type']=='UCD')) {
                            $updateData = [
                                'payment_status' => $orderStatus,
                                'response_data' => json_encode($results),
                            ];
                            DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->update($updateData);
                            echo "Deposit Transaction updated successfully!";
                            //Call webhook API START
                            $paymentDetail = DepositTransaction::where('systemgenerated_TransId', $systemgenerated_TransId)->first();
                            
                                // Broadcast the event Notification code START
                                    $data = [
                                        'type' => 'Callback Transaction Status',
                                        'transaction_id' => $paymentDetail->systemgenerated_TransId,
                                        'amount' => $paymentDetail->amount,
                                        'Currency' => $paymentDetail->Currency,
                                        'status' => $paymentDetail->payment_status,
                                        'msg' => 'Callback Transaction Status Updated!',
                                    ];
                                    event(new DepositCreated($data));   
                                    // Broadcast the event Notification code END
                                    // Insert data in Notification table Code START
                                    $addNotificationRecord = [
                                        'notifiable_type' => 'Callback Transaction Status',
                                        'agent_id' => $paymentDetail->agent_id,
                                        'merchant_id' => $paymentDetail->merchant_id,
                                        'data' => json_encode($data,true),
                                        'msg' => 'Callback Transaction Status Updated!',
                                    ];
                                    TransactionNotification::create($addNotificationRecord);
                                // Insert data in Notification table Code END

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
                            //Call webhook API END
                          

                }else{
                        $updateData = [
                            'status' => $orderStatus,
                            'api_response' => json_encode($results),
                        ];
                        SettleRequest::where('fourth_party_transection', $RefID)->update($updateData);
                        echo "Withdrawal Transaction updated successfully!";
                        //Call webhook API START
                        $paymentDetail = SettleRequest::where('fourth_party_transection', $RefID)->first();
                        $callbackUrl = $paymentDetail->callback_url;
                        $postData = [
                            'merchant_code' => $paymentDetail->merchant_code,
                            'referenceId' => $paymentDetail->merchant_track_id,
                            'transaction_id' => $paymentDetail->fourth_party_transection,
                            'amount' => $paymentDetail->total,
                            'Currency' => $paymentDetail->Currency,
                            'customer_name' => $paymentDetail->customer_name,
                            'payment_status' => $paymentDetail->status,
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
                }

        }else{
            return response()->json(['error' => 'Data Not Found or Invalid Request!'], 400);
        }
    }
    // COMMON PART END

}
