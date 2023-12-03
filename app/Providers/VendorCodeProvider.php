<?php

namespace App\Providers;

use App\Testing\VendorCodeService;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class VendorCodeProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(Generator::class, function (){
            $faker = Factory::create();
            $faker->addProvider(new VendorCodeService($faker));
            return $faker;
        });
    }

}
