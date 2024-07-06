<?php

namespace App\Providers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
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
        Schema::defaultStringLength(191);
        Validator::extend('old_password_match', function ($attribute, $value, $parameters, $validator) {
            // Add your logic to check if the old password matches the actual old password
            // You may use the Auth facade or any other method to retrieve the user's old password
            // For example, assuming you have the user object in the request, you can do something like:
            // return Hash::check($value, $this->request->user()->password);
            return Hash::check($value, auth()->user()->password);
        });
    }
}
