<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UOM;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['name' => 'kg'],
            ['name' => 'gm'],
            ['namn' => 'ton'],
        ];

       UOM::insert($data);
    }
}
