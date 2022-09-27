<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShipmentType;

class ShipmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['name' => 'air'],
            ['name' => 'ocean'],
            ['namn' => 'by_road'],
        ];

        ShipmentType::insert($data);
    }
}
