<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\User;
use App\UserMessage;
use App\Message;
use App\Comment;
use App\Order;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     *
     Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('admin-layout', function ($view) {
            $countUserMessages = UserMessage::where('user_id', '<>', Auth::id())
                ->where('isRead', 0)
                ->count();

            $countMessages = Message::where('isRead', 0)
                ->count();

            $countComments = Comment::where('status', 0)
                ->count();

            $countOrders = Order::whereHas('payments', function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNotNull('tracing_code')
                        ->orWhere('res_code', 0);
                });
            })->where('status',0)->count();


            $view
                ->with('countUserMessages', $countUserMessages)
                ->with('countMessages', $countMessages)
                ->with('countComments', $countComments)
                ->with('countOrders', $countOrders);
        });

        // if(Auth::check())
        // {
        //     $userLogined = User::find(Auth::id());
        //     View::composer('user.user-layout', function($view){
        //      $view
        //         ->with('userLogined', $userLogined);
        //     });
        // }

        // if (session()->has('cart')) {
        //     $list=collect();
        //     $cart = session('cart');

        //     foreach ($cart as $key => $value)
        //     {
        //         $class="App\\".$value['moddel'];
        //         $list->push($class::find($key));
        //     }
        //     // dd($cart);
        //     View::composer('admin-layout', function($view){
        //          $view
        //             ->with('cart', $cart)
        //             ->with('list', $list)
        //             ->with('countUserMessages',$countUserMessages);
        //     });
        // }
        // else
        // {

        // }
    }
}
