<?php

namespace App\Providers;

use Doctrine\Inflector\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pluralizer::useLanguage(Language::FRENCH);
    }
}
