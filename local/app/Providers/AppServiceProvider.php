<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Document;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);

      Validator::extend('unique_document', function($attribute, $value, $parameters, $validator) {
        $document=Document::where('number', $parameters[0])->where('date',$parameters[1])->where('category_id',$parameters[2])->exists();
        return $document;
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
