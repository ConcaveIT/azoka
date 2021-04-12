<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 4; $i++) {

            DB::table('products')->insert([
                'id' => $i,
                'category_id' => 1,
                'sub_category_id' => $i,
                'name' => 'Product ' . $i,
                'short_description' => $faker->realText(200, 2),
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(500, 5000),
                'discount' => $faker->numberBetween(10, 50),
                'image_primary' => 'storage/product/'.$i.'.jpg',
                'image_secondary' => 'storage/product/'.$i.'.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 5; $i <= 8; $i++) {

            DB::table('products')->insert([
                'id' => $i,
                'category_id' => 2,
                'sub_category_id' => $i,
                'name' => 'Product ' . $i,
                'short_description' => $faker->realText(200, 2),
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(500, 5000),
                'discount' => $faker->numberBetween(10, 50),
                'image_primary' => 'storage/product/'.$i.'.jpg',
                'image_secondary' => 'storage/product/'.$i.'.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 9; $i <= 12; $i++) {

            DB::table('products')->insert([
                'id' => $i,
                'category_id' => 3,
                'sub_category_id' => $i,
                'name' => 'Product ' . $i,
                'short_description' => $faker->realText(200, 2),
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(500, 5000),
                'discount' => $faker->numberBetween(10, 50),
                'image_primary' => 'storage/product/'.$i.'.jpg',
                'image_secondary' => 'storage/product/'.$i.'.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        for ($i = 13; $i <= 16; $i++) {

            DB::table('products')->insert([
                'id' => $i,
                'category_id' => 4,
                'sub_category_id' => $i,
                'name' => 'Product ' . $i,
                'short_description' => $faker->realText(200, 2),
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(500, 5000),
                'discount' => $faker->numberBetween(10, 50),
                'image_primary' => 'storage/product/'.$i.'.jpg',
                'image_secondary' => 'storage/product/'.$i.'.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}
