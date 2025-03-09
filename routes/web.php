<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Currency\CurrencyConverterController;
use App\Http\Controllers\Front\DestinationsController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ItinerariesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('/itineraries', ItinerariesController::class);
    
    Route::resource('/itineraries/{itinerary}/destinations', DestinationsController::class);

});


Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');


Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('auth.socilaite.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])
    ->name('auth.socilaite.callback');















require __DIR__ . '/auth.php';
