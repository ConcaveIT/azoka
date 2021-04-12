<?php

use Illuminate\Database\Seeder;

class FeaturedTableSeeder extends Seeder
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

            DB::table('featured_products')->insert([
                'category_id' => 1,
                'sub_category_id' => $i,
                'product_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 5; $i <= 8; $i++) {

            DB::table('featured_products')->insert([
                'category_id' => 2,
                'sub_category_id' => $i,
                'product_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 9; $i <= 12; $i++) {

            DB::table('featured_products')->insert([
                'category_id' => 3,
                'sub_category_id' => $i,
                'product_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 13; $i <= 16; $i++) {

            DB::table('featured_products')->insert([
                'category_id' => 4,
                'sub_category_id' => $i,
                'product_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


    }
}
