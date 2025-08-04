<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Tracked;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TrackController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/track', function (Request $request) {
    $tracked = Tracked::where(('user_id'), Auth::id())->get();
    return view('tracked', ['tracked' => $tracked]);
})->name('track');


Route::middleware(['auth'])->group(function () {
    Route::get('/track', [TrackController::class, 'index'])->middleware('auth')->name('track.index');
    Route::post('/track', [TrackController::class, 'store'])->name('track.store');
    Route::delete('/untrack/{domain}', [TrackController::class, 'destroy']);
    
});

Route::get('/test-mail', function () {
    Artisan::call('domains:expiry');
    return 'Mail command manually triggered.';
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/track', [TrackController::class, 'index'])->name('track');
//     // Add other protected routes like domain tracking etc.
// });

require __DIR__ . '/auth.php';
