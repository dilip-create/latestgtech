<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RichPayController;
use App\Http\Controllers\AJAXController;


use App\Livewire\Auth\LoginPage;
use App\Livewire\DashboardPage;
use App\Livewire\ProfilePage;
use App\Livewire\DepositTransactionList;
use App\Livewire\WithdrawTransactionList;
use App\Livewire\Fc\GenerateqrForm;
use App\Livewire\Fc\ShowQR;
use App\Livewire\Fc\QrcodeList;
use App\Livewire\Fc\DepositFormRichpay;
use App\Livewire\PaymentForm\R2p\RichpayPayinForm;
use App\Livewire\Agent\AgentList;
use App\Livewire\PaymentGateway\GatewayAccountList;
use App\Livewire\PaymentGateway\GatewayChannelList;
use App\Livewire\PaymentGateway\ChannelParameter;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index']);
Route::get('/table', [HomeController::class, 'datatable']);

Route::get('/', LoginPage::class)->name('login');
Route::get('/login', LoginPage::class)->name('login');
Route::get('/dashboard', DashboardPage::class)->name('dashboard');
Route::get('/profile', ProfilePage::class)->name('user.profile');
Route::get('/transactions/deposit', DepositTransactionList::class)->name('transactions.deposit');
Route::get('/transactions/withdraw', WithdrawTransactionList::class)->name('transactions.withdraw');
Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");
// FC Start
Route::get('/generate/FCQR', GenerateqrForm::class)->name('generate.FCQR');
Route::get('/showQR/{recordID}', ShowQR::class)->name('showQR');
Route::get('/invoice-qrcode-list', QrcodeList::class)->name('invoice.qrcode.list');


Route::controller(AJAXController::class)->group(function () {
   
    Route::get('/get-record/{id}', 'getRecord');
    Route::post('/gateway/toggle-status', 'toggleStatus')->name('gateway.toggleStatus');
    Route::get('/get-gatewayAccount-record/{id}', 'getgatewayAccountRecord');
    Route::post('/saveGatewayAccountData', 'saveGatewayAccountData')->name('GatewayAccount.save');
    

});

// Route::get('fc/r2pdeposit/{amount}/{invoice_number}/{customer_name}', 'fcs2pDeposit')->name('fc.s2p.Deposit');

Route::get('/fc/r2pdeposit/{amount}/{invoice_number}/{customer_name}', DepositFormRichpay::class)->name('fc.r2pdeposit');
Route::get('/r2pPayin', RichpayPayinForm::class)->name('r2p.deposit.form');

Route::controller(RichPayController::class)->group(function () {
    
    Route::get('/r2pPaymentPage/{frtransaction}', 'paymentPage');
    Route::get('/r2pPaymentPage2/{frtransaction}', 'paymentProcessingPage');
    Route::get('r2p/payinResponse/{frtransaction}', 'payinResponse');
    // Route::get('/r2pPayout', 'r2pPayoutform'); 

    Route::get('/r2p/payintest', 'payintest'); 
    // Route::get('/r2p/payouttest', 'payouttest'); 

    Route::get('sendDepositNotification/{id}', 'sendDepositNotification');
});


Route::get('/agent-lists', AgentList::class)->name('agent.list');
Route::get('/gateway-account-list', GatewayAccountList::class)->name('gateway.account.list');
Route::get('/payment-channel-list', GatewayChannelList::class)->name('payment.channel.list');
Route::get('/channel-parameter-list', ChannelParameter::class)->name('channel.parameter.list');




 
