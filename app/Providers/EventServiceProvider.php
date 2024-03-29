<?php

namespace App\Providers;

use App\Models\Quotes\Quote;
use App\Models\Users\User;
use App\Observers\UuiDObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        parent::boot();

        $this->registerUuidObservers();
    }

    public function registerUuidObservers()
    {
        User::observe(app(UuiDObserver::class));

        Quote::observe(app(UuiDObserver::class));
    }
}
