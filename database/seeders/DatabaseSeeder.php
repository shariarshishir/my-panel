<?php

namespace Database\Seeders;

use App\Models\ShipmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            WholeSalerSeeder::class,
            CategorySeeder::class,
            UomSeeder::class,
            ShippingMethodSeeder::class,
            ShipmentTypeSeeder::class,
            ]);
    }
}
