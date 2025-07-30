<?php

namespace App\Console\Commands;

use App\Mail\DomainExpiryNotification;
use Illuminate\Console\Command;
use App\Models\Tracked;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class NotifyExpiringDomains extends Command
{
    protected $signature = 'domains:notify';
    protected $description = 'Send email reminders for domains expiring soon';

    public function handle()
    {
        $today = Carbon::today();

        $tracked = Tracked::all();

        foreach ($tracked as $item) {
            $this->info('Checking notification for domain ' . $item->domain);
            if (!$item->expiry || !$item->email || !$item->notifyDays) {
                $this->error('Skipped domain ' . $item->domain . ' because it is missing some parameters: ' . json_encode($item));
                continue;
            }
            $expiryDate = Carbon::parse($item->expiry);
            $daysLeft = $today->diffInDays($expiryDate);

            
            if ($daysLeft == $item->notifyDays) {
                Mail::to($item->email)->send(new DomainExpiryNotification(
                    domain: $item->domain,
                    expiry: $expiryDate->toDateString(),
                    daysLeft: $daysLeft
                ));

                $this->info("Sent reminder to {$item->email} for: {$item->domain} (expires in {$daysLeft} days)");
            } else {
                $this->info("{$item->domain} expires in $daysLeft days. No reminder sent." . $item->notifyDays);
            }
        }

        return 0;
    }
}
