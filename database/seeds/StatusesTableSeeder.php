<?php

use App\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    public function run()
    {
        Status::truncate();

        $faker = Faker\Factory::create();

        foreach (range(70, 1) as $index) {
            $timePosted = Carbon::now()->subDays($index);

            Status::create([
                'user_id' => rand(1, 7),
                'body' => $faker->sentence(10, false),
                'created_at' => $timePosted,
                'updated_at' => $timePosted,
            ]);
        }
    }
}
