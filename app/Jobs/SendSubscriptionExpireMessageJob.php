<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionExpireMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customer, $expire_date;

    /**
     * Create a new job instance.
     */
    public function __construct($customer, $expire_date)
    {
        $this->customer = $customer;
        $this->expire_date = $expire_date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customer = $this->customer;
        $subject = "Expire Subscription";
        $data = [];
        // send mail
        Mail::send('emails.subscription_expiration', $data, function ($mail) use ($customer, $subject) {
            $mail->subject($subject);
            $mail->to($customer->email);
        });
    }
}
