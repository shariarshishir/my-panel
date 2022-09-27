<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // ProductCategory::factory()->times(5)->create();
      $data=[
           [
            'name' => 'category1',
            'slug' => 'category-one',
            'status' => 1,
            'parent_id' => null,
            'created_by' => 1,
           ],
           [
            'name' => 'category2',
            'slug' => 'category-two',
            'status' => 1,
            'parent_id' => null,
            'created_by' => 1,
           ],
           [
            'name' => 'category3',
            'slug' => 'category-three',
            'status' => 1,
            'parent_id' => 1,
            'created_by' => 1,
           ],
           [
            'name' => 'category4',
            'slug' => 'category-four',
            'status' => 1,
            'parent_id' => 2,
            'created_by' => 1,
           ],
      ];

      ProductCategory::insert($data);
    }
}
