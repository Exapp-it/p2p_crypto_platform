<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\User\MainController;

Route::middleware('auth')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('', [MainController::class, 'index'])
            ->name('user');

        Route::get('wallets', [MainController::class, 'wallets'])
            ->name('user.wallets');
    });

    Route::prefix('trade')->group(function () {
        Route::get('', [TradeController::class, 'index'])
            ->name('trade');

        Route::get('buy', [TradeController::class, 'buy'])
            ->name('trade.buy');

        Route::get('sell', [TradeController::class, 'sell'])
            ->name('trade.sell');
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
});
