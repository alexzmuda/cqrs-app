<?php

namespace App\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the categories seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            ['id' => 1, 'name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95],
            ['id' => 2, 'name' => 'Green Widget', 'code' => 'G01', 'price' => 24.95],
            ['id' => 3, 'name' => 'Blue Widget', 'code' => 'B01', 'price' => 7.95]
        ];

        foreach ($categories as $category) {
            if (null === DB::table('products')->where('id', '=', $category['id'])->first()) {
                DB::table('products')->insert([
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'code' => $category['code'],
                    'price' => $category['price']
                ]);
            }
        }
    }
}
