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
    }
}
