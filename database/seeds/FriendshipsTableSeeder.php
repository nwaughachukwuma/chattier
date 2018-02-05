<?php

use Illuminate\Database\Seeder;

class FriendshipsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('friendships')->truncate();

        DB::table('friendships')->insert([
            [
                'requester' => 2,
                'user_requested' => 1,
                'status' => 1,
            ],
            [
                'requester' => 1,
                'user_requested' => 3,
                'status' => 1,
            ],
            [
                'requester' => 4,
                'user_requested' => 1,
                'status' => 0,
            ],
            [
                'requester' => 5,
                'user_requested' => 1,
                'status' => 0,
            ],
            [
                'requester' => 1,
                'user_requested' => 6,
                'status' => 0,
            ],
            [
                'requester' => 2,
                'user_requested' => 6,
                'status' => 1,
            ],
            [
                'requester' => 2,
                'user_requested' => 7,
                'status' => 1,
            ],
            [
                'requester' => 3,
                'user_requested' => 6,
                'status' => 1,
            ],
            [
                'requester' => 3,
                'user_requested' => 7,
                'status' => 1,
            ],
        ]);
    }
}
