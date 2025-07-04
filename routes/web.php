<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;

use App\Livewire\Auth\LoginPage;
use App\Livewire\DashboardPage;
use App\Livewire\DepositTransactionList;
use App\Livewire\WithdrawTransactionList;
use App\Livewire\Fc\GenerateqrForm;
use App\Livewire\Fc\ShowQR;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index']);
Route::get('/table', [HomeController::class, 'datatable']);

Route::get('/', LoginPage::class)->name('login');
Route::get('/login', LoginPage::class)->name('login');
Route::get('/dashboard', DashboardPage::class)->name('dashboard');
Route::get('/transactions/deposit', DepositTransactionList::class)->name('transactions.deposit');
Route::get('/transactions/withdraw', WithdrawTransactionList::class)->name('transactions.withdraw');
Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");
// FC Start
Route::get('/generate/FCQR', GenerateqrForm::class)->name('generate.FCQR');
Route::get('/showQR/{id}', ShowQR::class)->name('showQR');


