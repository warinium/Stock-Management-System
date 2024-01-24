<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Models\Customer;
use App\Models\Models\Product;
use App\Models\Models\Provider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\ProviderFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create();
        Product::factory()->count(50)->create();
        Customer::factory()->count(10)->create();
        Provider::factory()->count(3)->create();
    }
}
