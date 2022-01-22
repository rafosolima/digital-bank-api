<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\IUserRepository',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\IWalletRepository',
            'App\Repositories\WalletRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\ITransactionRepository',
            'App\Repositories\TransactionRepository'
        );
    }
}
