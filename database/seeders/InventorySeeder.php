<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i=1; $i < 10 ; $i++) { 
            Inventory::create([
                'name'=>  $faker->name,
                'code'=>  'IN00'.$i,
                'price'=> $faker->numberBetween(100000,1000000),
                'stock'=> $faker->numberBetween(1,100),
            ]);
        } 
    }
}
