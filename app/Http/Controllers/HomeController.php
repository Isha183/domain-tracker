<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Iodev\Whois\Factory;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $domain = $request->query('domain');
        $domain = preg_replace('/^(https?:\/\/)?(www\.)?/i', '', trim($domain));
        $domain = strtolower($domain);

        $history = SearchHistory::where('user_id', Auth::id())
            ->orderBy('searched_at', 'desc')
            ->take(3)
            ->get();



        if (!$domain) {
            return view('home', [
                'history' => $history,
                'error' => 'No domain provided'
            ]);
        }

        $cacheKey = 'whois_' . $domain;
        $info = Cache::get($cacheKey);

        // Always load search history (even if cached)

        if (!$info) {
            try {
                $whois = (new Factory())->createWhois();
                $info = $whois->loadDomainInfo($domain);
                $raw = $whois->lookupDomain($domain)->text ?? 'No raw response';

                if ($info) {
                    Cache::put($cacheKey, $info, now()->addHour());
                }
            } catch (\Exception $e) {
                return view('home', [
                    'error' => 'Failed to fetch WHOIS data: ' . $e->getMessage(),
                    'domain' => $domain,
                    'raw' => null,
                    'history' => $history,
                ]);
            }
        } else {
            $raw = null;
            Log::info("Loaded WHOIS from cache for domain: {$domain}");
        }

        // Save the search to DB
        SearchHistory::create([
            'user_id' => Auth::id(),
            'domain' => $domain,
            'searched_at' => now()
        ]);

        return view('home', [
            'domain' => $domain,
            'created' => $info->creationDate ? date('Y-m-d', $info->creationDate) : null,
            'expires' => $info->expirationDate ? date('Y-m-d', $info->expirationDate) : null,
            'updated' => $info->updatedDate ? date('Y-m-d', $info->updatedDate) : null,
            'owner' => $info->owner ?? null,
            'registrar' => $info->registrar ?? null,
            'raw' => $raw,
            'history' => $history,
        ]);
    }
}
