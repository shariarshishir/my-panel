<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductTypeMapping as ProductMapping;

class ProductTypeMapping extends Seeder
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
             'title' => 'studio',
             'parent_id' => null,
            ],
            [
            'title' => 'raw materials',
            'parent_id' => null,
            ],
            [
            'title' => 'design',
            'parent_id' => 1,
            ],
            [
            'title' => 'product sample',
            'parent_id' => 1,
            ],
            [
            'title' => 'ready stock',
            'parent_id' => 1,
            ],
            [
            'title' => 'textile',
            'parent_id' => 2,
            ],
            [
            'title' => 'yarn',
            'parent_id' => 2,
            ],
            [
            'title' => 'trims and accessories',
            'parent_id' => 2,
            ],
       ];

       ProductMapping::insert($data);
    }
}
