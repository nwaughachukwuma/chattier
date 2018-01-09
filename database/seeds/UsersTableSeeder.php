<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'email' => 'ranie@gmail.com',
            'username' => 'ranie',
            'password' => 'password',
            'firstname' => 'Ranie',
            'lastname' => 'Santos',
            'location' => 'Manila, PH',
        ]);

        User::create([
            'email' => 'alex@gmail.com',
            'username' => 'alex',
            'password' => 'password',
            'firstname' => 'Alex',
            'lastname' => 'Garrett',
            'location' => 'London, UK',
        ]);

        $faker = Faker\Factory::create();

        $names = ['barney', 'casey', 'dale', 'elma', 'fred'];

        foreach ($names as $name) {
            User::create([
                'email' => $name . '@gmail.com',
                'username' => $name,
                'password' => 'password',
                'firstname' => ucfirst($name),
                'lastname' => $faker->lastName(),
            ]);
        }
    }
}
