<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
    * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        UserMessage::class => UserMessagePolicy::class,
        Tablecloth::class => TableclothPolicy::class,
        Bedcover::class => BedcoverPolicy::class,
        Fabric::class => FabricPolicy::class,
        Pillow::class => PillowPolicy::class,
        Prayermat::class => PrayermatPolicy::class,
        Order::class => OrderPolicy::class,
        Orderitem::class => OrderitemPolicy::class,
        Message::class => MessagePolicy::class,
        Favorite::class => FavoritePolicy::class,
        Comment::class => CommentPolicy::class,
        CardPayment::class => CardPaymentPolicy::class,
        Color::class => ColorPolicy::class,
        Design::class => DesignPolicy::class,
        DiscountCard::class => DiscountCardPolicy::class,
        Recipient::class => RecipientPolicy::class,
        Slideshow::class => SlideshowPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('selectTag', function ($user) {
        //     return $user->isAdmin();
        // });

        Gate::define('index-newsletter', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('export-newsletter', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('store-grade', function ($user) {
            return $user->id === Auth::id();
        });

        // Gate::define('cartlevel2-cart', function ($user) {
        //     return $user->id === Auth::id();
        // });

        // Gate::define('cartfinal-cart', function ($user) {
        //     return $user->id === Auth::id();
        // });


        

    }
}
