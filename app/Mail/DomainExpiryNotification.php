<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DomainExpiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $domain, public $expiry, public $daysLeft)
    {
    }

    public function build()
    {
        return $this->subject('Domain Expiry Alert')
            ->view('emails.expiry', [
                'daysLeft' => $this->daysLeft,
                'expiry' => $this->expiry,
                'domain' => $this->domain,
            ]); // You will create this Blade view
    }
}
