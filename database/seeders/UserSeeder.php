<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'name'=>'Super Admin',
               'email'=>'superadmin@test.com',
               'password'=> bcrypt('123456'),
               'role'=>'SuperAdmin',
            ],
            [
                'name'=>'Sales Admin',
                'email'=>'sales@test.com',
                'password'=> bcrypt('123456'),
                'role'=>'Sales',
             ],
             [
                'name'=>'Purchase Admin',
                'email'=>'purchase@test.com',
                'password'=> bcrypt('123456'),
                'role'=>'Purchase',
             ],
             [
                'name'=>'Manager',
                'email'=>'manager@test.com',
                'password'=> bcrypt('123456'),
                'role'=>'Manager',
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }

        $faker = Faker::create('id_ID');
        
        for ($i=0; $i < 50 ; $i++) { 
            User::create([
                'name'=>  $faker->name,
                'email'=>  $faker->email,
                'password'=> bcrypt('123456'),
                'role'=> $faker->randomElement(['SuperAdmin','Sales','Purchase','Manager']),
            ]);
        } 
    }
}
