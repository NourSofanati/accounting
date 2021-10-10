<?php

namespace App\Providers;

use App\Models\MaterialSpending;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Vendor;
use App\Observers\MaterialSpendingObserver;
use App\Observers\PurchaseItemObserver;
use App\Observers\PurchaseObserver;
use App\Observers\VendorObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Vendor::observe(VendorObserver::class);
        Purchase::observe(PurchaseObserver::class);
        PurchaseItem::observe(PurchaseItemObserver::class);
        MaterialSpending::observe(MaterialSpendingObserver::class);
    }
}
