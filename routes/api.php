<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RichPayController;
use App\Http\Controllers\IpintPaymentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(RichPayController::class)->group(function () {
    Route::get('r2p/payin', 'payin')->name('apiroute.r2p.payin');                      // For call API
    Route::post('r2p/payin/callbackURL', 'r2pPayinCallbackURL')->name('apiroute.r2pPayincallbackURL');    // For sending callback on frontend
    Route::post('/r2pDepositNotifiication', 'r2pDepositNotifiication');                // For sending callback on Backend
    
    // Route::get('r2p/payout', 'payout')->name('apiroute.r2p.payout');                      // For call API
    // Route::post('r2p/payout/callbackURL', 'r2pPayoutcallbackURL')->name('apiroute.r2pPayoutcallbackURL');    // For sending callback on frontend
    // Route::post('/r2pWithdrawNotifiication', 'r2pWithdrawNotifiication');                           // For sending callback on Backend
});

Route::controller(IpintPaymentController::class)->group(function () {
    Route::get('ip/checkout', 'ipintCheckout')->name('apiroute.ipint.checkout');
    Route::post('ip/depositResponse', 'ipintdepositResponse')->name('apiroute.ipint.depositResponse'); 
    Route::post('/ipintDeposit/WebhookNotifiication', 'ipintDepositWebhookNotifiication'); 
});
