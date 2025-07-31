<?php

namespace App\Http\Controllers;

use Iodev\Whois\Factory;
use Illuminate\Http\Request;
use App\Models\Tracked;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|string',
            'email' => 'required|email',
            'expiry' => 'required|date',
            'days' => 'required|integer|min:1'
        ]);

        $domain = Str::of($request->input('domain'))
            ->replaceFirst('https://', '')
            ->replaceFirst('http://', '')
            ->replaceFirst('www.', '')
            ->trim()
            ->toString();

        $whois = (new Factory())->createWhois();
        $info = $whois->loadDomainInfo($domain);

        if (!$info || !$info->expirationDate) {
            return back()->withErrors(['error' => 'Could not retrieve WHOIS expiry for this domain.']);
        }

        $expiry = date('Y-m-d', $info->expirationDate);

        // Check if the domain is new (not already tracked)
        $existing = Tracked::where('domain', $domain)->first();

        Tracked::create([
            'domain'     => $request->domain,
            'expiry'     => $request->expiry,
            'email'      => $request->email,
            'notifyDays' => $request->days,
            'user_id'    => Auth::id(),
        ]);

        // Tracked::updateOrCreate(
        //     ['domain' => $domain],
        //     [

        //         'expiry' => $request->input('expiry'),
        //         'email' => $request->input('email'),
        //         'notifyDays' => (int) $request->input('days')
        //     ]
        // );

        // Log::info("Triggering domains:notify for newly tracked domain: {$domain}");

        // Artisan::call('domains:notify');

        // Log::info("domains:notify command finished for: {$domain}");

        if (!$existing) {
            Log::info("New domain tracked: {$domain}. Running domains:notify...");
            Artisan::call('domains:notify');
            Log::info("domains:notify executed for new domain: {$domain}");
        } else {
            Log::info("Domain {$domain} was already tracked. No notify triggered.");
        }

        return redirect()->route('track.index')->with('success', 'Domain tracking started.');
    }

    public function index()
    {
        $tracked = Tracked::where(('user_id'), Auth::id())->get();
        return view('tracked', compact('tracked'));
    }

    public function destroy($domain)
    {
        Tracked::where('domain', $domain)->where('user_id', Auth::id()) ->delete();
        return redirect()->route('track.index')->with('success', 'Domain removed.');
    }
}
