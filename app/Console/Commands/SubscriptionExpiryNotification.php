<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionExpireMessageJob;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:subscription-expiry-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check which subscriped users have been expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired_customers = Customer::where('subscription_end_date', '<', now())->get();
        foreach ($expired_customers as $customer) {
            info("i'm here in line 33");
            $expire_date = Carbon::createFromFormat('Y-m-d', $customer->subscription_end_date)->toDateString();
            dispatch(new SendSubscriptionExpireMessageJob($customer, $expire_date));
        }
    }
}
