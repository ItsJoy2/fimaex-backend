<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CronController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\TicketController;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Http\Controllers\api\DepositController;
use App\Http\Controllers\api\PackagesController;
use App\Http\Controllers\api\AutoDepositController;
use App\Http\Controllers\api\TransactionsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

//user
Route::prefix('user')->middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('profile', [UserController::class, 'UserProfile']);
    Route::post('profile/update', [AuthController::class, 'profileUpdate']);
    Route::post('kyc-submit', [UserController::class, 'kyc']);
    Route::get('team', [UserController::class, 'team']);
    Route::get('direct-refer', [UserController::class, 'getDirectReferrals']);
    Route::post('buy-package/{id}', [PackagesController::class, 'BuyPackage']);
    Route::get('package', [PackagesController::class, 'getPackages']);
    Route::get('transactions', [TransactionsController::class, 'transactions']);
    Route::get('invest-history', [PackagesController::class, 'InvestHistory']);
    Route::post('transfer', [TransactionsController::class, 'transfer']);
    Route::post('withdraw', [TransactionsController::class, 'withdraw']);

    Route::get('general-settings', [UserController::class, 'generalSettings']);

    // club list
    Route::get('clubs', [UserController::class, 'clubList']);

    // support Message
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'create']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply']);
    Route::post('/tickets/{ticket}/resolve', [TicketController::class, 'resolve']);

    //deposit
   Route::post('deposit', [DepositController::class, 'addDeposit']);


});

//EmailSendSystem
Route::prefix('user')->middleware(['throttle:3,1'])->group(function () {
    Route::post('/email/verification-notification',[EmailController::class,'sendVerificationEmail'])->middleware('auth:sanctum');
    Route::get('/verify-email/{id}/{hash}',[EmailController::class,'verify'])->middleware(['signed'])->name('verification.verify');
});

Route::post('paymentHooks', [AutoDepositController::class, 'PaymentHooks']);
//cron
Route::post('forget-password-send-mail',[AuthController::class, 'ForgotPasswordSendEmail']);
Route::post('reset-password',[AuthController::class, 'ResetPassword']);
Route::get('cron',[CronController::class, 'cronJob']);
Route::get('trx-cron',[CronController::class, 'paymentCheck']);
require __DIR__ . '/auths.php';

