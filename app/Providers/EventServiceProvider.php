<?php

namespace App\Providers;

use App\Events\NewOrderHasApprovedEvent;
use App\Events\NewUserHasRegisteredEvent;
use App\Events\NewAnonymousUserHasRegisteredEvent;
use App\Events\NewOrderHasPlacedEvent;
use App\Events\NewOrderModificationRequestEvent;
use App\Events\OrderQueryEvent;
use App\Events\OrderQueryFromAdminEvent;
use App\Events\PaymentSuccessEvent;
use App\Events\ProductAvailabilityEvent;
use App\Events\NewBusinessProfileHasCreatedEvent;
use App\Events\NewBusinessProfileVerificationRequestEvent;
use App\Events\NewProfromaInvoiceHasCreatedEvent;
use App\Events\ProfromaInvoiceHasRejectedEvent;
use App\Events\ProfromaInvoiceHasAcceptedEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewRfqHasAddedEvent;
use App\Events\NewRfqHasPublishedEvent;
use App\Events\NewRfqHasBidEvent;
use App\Events\NewRFQHasPostedEvent;
use App\Events\NewQuotationHasPostedEvent;
use App\Models\BusinessProfile;
use App\Observers\ManageBusinessProfileObserver;

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
        NewOrderHasPlacedEvent::class => [
            'App\Listeners\NewOrderHasPlacedListener',
        ],
        NewOrderHasApprovedEvent::class => [
            'App\Listeners\NewOrderHasApprovedListener',
        ],
        NewUserHasRegisteredEvent::class => [
            'App\Listeners\NewUserHasRegisteredListener',
        ],
        NewAnonymousUserHasRegisteredEvent::class => [
            'App\Listeners\NewAnonymousUserHasRegisteredListener',
        ],
        NewRFQHasPostedEvent::class => [
            'App\Listeners\NewRFQHasPostedListener',
        ],
        NewQuotationHasPostedEvent::class => [
            'App\Listeners\NewQuotationHasPostedListener',
        ],
        NewOrderModificationRequestEvent::class=>[
            'App\Listeners\NewOrderModificationRequestListener',
        ],
        ProductAvailabilityEvent::class=>[
            'App\Listeners\ProductAvailabilityListener',
        ],
        OrderQueryEvent::class=>[
            'App\Listeners\OrderQueryListener',
        ],
        OrderQueryFromAdminEvent::class=>[
            'App\Listeners\OrderQueryFromAdminListener',
        ],
        PaymentSuccessEvent::class=>[
            'App\Listeners\PaymentSuccessListener',
        ],
        NewRfqHasAddedEvent::class => [
            'App\Listeners\NewRfqInvitationListener',
        ],
        NewRfqHasPublishedEvent::class => [
            'App\Listeners\NewRfqHasPublishedListener',
        ],
        NewRfqHasBidEvent::class => [
            'App\Listeners\NewRfqHasBidListener',
        ],
        NewBusinessProfileHasCreatedEvent::class => [
            'App\Listeners\NewBusinessProfileHasCreatedListener',
        ],
        NewBusinessProfileVerificationRequestEvent::class => [
            'App\Listeners\NewBusinessProfileVerificationRequestListener',
        ],
        NewProfromaInvoiceHasCreatedEvent::class => [
            'App\Listeners\NewProfromaInvoiceHasCreatedListener',
        ],
        ProfromaInvoiceHasRejectedEvent::class => [
            'App\Listeners\ProfromaInvoiceHasRejectedListener',
        ],
        ProfromaInvoiceHasAcceptedEvent::class => [
            'App\Listeners\ProfromaInvoiceHasAcceptedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        BusinessProfile::observe(ManageBusinessProfileObserver::class);
    }
}
