<?php

use Illuminate\Database\Seeder;

class SlideTableSeeder extends Seeder
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

        DB::table('sliders')->insert([
            'title' => 'Skin Care',
            'exert' => $faker->realText(100, 2),
            'image' => 'storage/slider/1.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('sliders')->insert([
            'title' => 'Makeup',
            'exert' => $faker->realText(100, 2),
            'image' => 'storage/slider/2.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('sliders')->insert([
            'title' => 'Hair Care',
            'exert' => $faker->realText(100, 2),
            'image' => 'storage/slider/3.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('sliders')->insert([
            'title' => 'Clothing',
            'exert' => $faker->realText(100, 2),
            'image' => 'storage/slider/4.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
