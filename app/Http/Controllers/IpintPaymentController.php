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
}
