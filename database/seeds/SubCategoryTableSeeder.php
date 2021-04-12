<?php

use Illuminate\Database\Seeder;

class SubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for ($i = 1; $i <= 4; $i++) {

            DB::table('sub_categories')->insert([
                'id' => $i,
                'category_id' => 1,
                'name' => 'Skin Care ' . $i,
                'image' => 'storage/subcategory/1.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 5; $i <= 8; $i++) {

            DB::table('sub_categories')->insert([
                'id' => $i,
                'category_id' => 2,
                'name' => 'Makeup ' . $i,
                'image' => 'storage/subcategory/2.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 9; $i <= 12; $i++) {

            DB::table('sub_categories')->insert([
                'id' => $i,
                'category_id' => 3,
                'name' => 'Hair Care ' . $i,
                'image' => 'storage/subcategory/3.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 13; $i <= 16; $i++) {

            DB::table('sub_categories')->insert([
                'id' => $i,
                'category_id' => 4,
                'name' => 'Clothing ' . $i,
                'image' => 'storage/subcategory/4.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }



    }
}
