<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Factory;
use App\Models\Tracked;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;


Route::get('/', function (Request $request) {
    $domain = $request->query('domain');
    $domain = preg_replace('/^(https?:\/\/)?(www\.)?/i', '', trim($domain));
    $domain = strtolower($domain);
    if (!$domain) {
        return view('home', ['error' => 'No domain provided']);
    }

    // Generate a cache key using the domain name
    $cacheKey = 'whois_' . strtolower($domain);


    // Try to get WHOIS info from cache
    $info = Cache::get($cacheKey);

    if ($info) {
        Log::info("Loaded WHOIS from cache for domain: {$domain}");

        return view('home', [
            'domain' => $domain,
            'created' => $info->creationDate ? date('Y-m-d', $info->creationDate) : null,
            'expires' => $info->expirationDate ? date('Y-m-d', $info->expirationDate) : null,
            'updated' => $info->updatedDate ? date('Y-m-d', $info->updatedDate) : null,
            'owner' => $info->owner ?? null,
            'registrar' => $info->registrar ?? null,
            'raw' => null,
        ]);
    }

    Log::info("Cache miss for domain: {$domain}");




    try {
        $whois = (new Factory())->createWhois();
        $info = $whois->loadDomainInfo($domain);
        $raw = $whois->lookupDomain($domain)->text ?? 'No raw response';

        if (!$info) {
            return view('home', [
                'error' => 'WHOIS data not found for this domain',
                'domain' => $domain,
                'raw' => $raw
            ]);
        }
        // Cache the data for 1 hour
        Cache::put($cacheKey, $info, now()->addHour());

        return view('home', [
            'domain' => $domain,
            'created' => $info->creationDate ? date('Y-m-d', $info->creationDate) : null,
            'expires' => $info->expirationDate ? date('Y-m-d', $info->expirationDate) : null,
            'updated' => $info->updatedDate ? date('Y-m-d', $info->updatedDate) : null,
            'owner' => $info->owner ?? null,
            'registrar' => $info->registrar ?? null,
            'raw' => $raw,
        ]);
    } catch (\Exception $e) {
        return view('home', [
            'error' => 'Failed to fetch WHOIS data: ' . $e->getMessage(),
            'domain' => $domain,
            'raw' => null
        ]);
    }
});

Route::get('track', function (Request $request) {
    $tracked = Tracked::all();
    return view('tracked', ['tracked' => $tracked]);
});



Route::post('/track', [TrackController::class, 'store'])->name('track.store');
Route::get('/track', [TrackController::class, 'index'])->name('track.index');
Route::delete('/untrack/{domain}', [TrackController::class, 'destroy']);
Route::get('/test-mail', function () {
    Mail::raw("This is a test email from Laravel to Mailpit!", function ($message) {
        $message->to('test@example.com')
                ->subject("Test Email");
    });

    return 'Mail sent!';
});