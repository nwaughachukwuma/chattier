<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config = json_encode([
            'app' => collect(config('app'))
                ->only(['name', 'env', 'url']),
        ]);

        view()->share(compact('config'));
    }

    public function register()
    {
        //
    }
}
