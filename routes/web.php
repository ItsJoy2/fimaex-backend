<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CronController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\admin\KycController;
use App\Http\Controllers\admin\PlansController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\DepositController;
use App\Http\Controllers\admin\WithdrawController;
use App\Http\Controllers\admin\AdminClubController;
use App\Http\Controllers\admin\AdminTicketController;
use App\Http\Controllers\admin\FounderBonusController;
use App\Http\Controllers\admin\TransactionsController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\GeneralSettingsController;
use App\Http\Controllers\admin\WithdrawSettingsController;
use App\Http\Controllers\admin\ReferralsSettingsController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard',[AdminDashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //all user
    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::post('users/update', [UsersController::class, 'update'])->name('users.update');
    Route::resource('all-plan', PlansController::class);
    Route::resource('withdraw', WithdrawController::class);
    Route::resource('transactions', TransactionsController::class);
    Route::resource('kyc', KycController::class);
    Route::resource('clubs', AdminClubController::class);
    Route::get('cron', [CronController::class, 'view'])->name('cron');


    Route::get('/withdraws/settings', [WithdrawSettingsController::class, 'index'])->name('withdraw.settings');
    Route::post('/withdraws/settings', [WithdrawSettingsController::class, 'update'])->name('admin.withdraw.settings.update');


    Route::get('ReferralsSettings',[ReferralsSettingsController::class,'index'])->name('ReferralsSettings');
    Route::post('ReferralsSettings',[ReferralsSettingsController::class,'update'])->name('admin.referral.settings.update');


    //deposit
    Route::resource('/deposit', DepositController::class);


    // support ticket
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{id}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/tickets/{id}/reply', [AdminTicketController::class, 'reply'])->name('admin.tickets.reply');
    Route::post('/tickets/{id}/close', [AdminTicketController::class, 'close'])->name('admin.tickets.close');

    //Founder Bonus
    Route::get('/founder-bonus', [FounderBonusController::class, 'index'])->name('admin.founder.bonus');
    Route::post('/founder-bonus/send', [FounderBonusController::class, 'sendFounderBonus'])->name('admin.founder.bonus.send');

    // General Settings
    Route::get('general-settings', [GeneralSettingsController::class, 'index'])->name('admin.general.settings');
    Route::post('general-settings', [GeneralSettingsController::class, 'update'])->name('admin.general.settings.update');

});

Route::get('check',function(){
    return \Carbon\Carbon::now();
});

require __DIR__.'/auth.php';
