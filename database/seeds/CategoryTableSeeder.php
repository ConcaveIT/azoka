<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'id' => 1,
            'name' => 'Skin Care',
            'image' => 'storage/category/1.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => 2,
            'name' => 'Makeup',
            'image' => 'storage/category/2.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => 3,
            'name' => 'Hair Care',
            'image' => 'storage/category/3.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => 4,
            'name' => 'Clothing',
            'image' => 'storage/category/4.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
