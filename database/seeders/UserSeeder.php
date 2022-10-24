<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
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
                'name' => 'wholesaler1',
                'user_id' => 0001,
                'email' => 'wholesaler1@shopmerchantbay.com',
                'phone'  => 7654343479,
                'user_type' => 'wholesaler',
                'image'    => 'images/frontendimages/no_user.png',
                'password' => bcrypt('12345678'),
                'is_email_verified' => 1,
              ],
              [
                'name' => 'wholesaler2',
                'user_id' =>0002,
                'email' => 'wholesaler2@shopmerchantbay.com',
                'phone'  => 34343433,
                'user_type' => 'wholesaler',
                'image'    => 'images/frontendimages/no_user.png',
                'password' => bcrypt('12345678'),
                'is_email_verified' => 1,
              ],
              [
                'name' => 'buyer',
                'user_id' =>0003,
                'email' => 'buyer@shopmerchantbay.com',
                'phone'  => 34343433,
                'user_type' => 'buyer',
                'image'    => 'images/frontendimages/no_user.png',
                'password' => bcrypt('12345678'),
                'is_email_verified' => 1,
              ],
        ];
        User::insert($data);
    }
}
