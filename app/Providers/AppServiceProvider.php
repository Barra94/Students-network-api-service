<?php

namespace App\Providers;

use App\Models\Fontys\Fontys;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindFontys();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }

    private function bindFontys()
    {
        $this->app->singleton(Fontys::class, function ($app){
           $client =  new Client([
               'base_uri' => config('app.fontys.Base_Uri'),
           ]);

           return new Fontys($client);
        });
    }
}
