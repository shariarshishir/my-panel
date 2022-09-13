<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class WholeSalerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                'user_id' => 1,
                'vendor_uid' =>7474,
                'vendor_name' => 'vendor1',
                'vendor_address' => 'vendor1 address',
            ],
            [
                'user_id' => 2,
                'vendor_uid' =>7575,
                'vendor_name' => 'vendor2',
                'vendor_address' => 'vendor2 address',
            ],
            [
                'user_id' => 3,
                'vendor_uid' =>7676,
                'vendor_name' => 'buyer',
                'vendor_address' => 'buyer address',
            ],

      ];
      Vendor::insert($data);
    }
}

// factory(App\Models\User::class, 1)->create()->each(function ($u) {
//     $u->vendor()->saveMany(factory(App\Models\Vendor::class, 1)->create());
//   });
