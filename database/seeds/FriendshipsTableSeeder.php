<?php

use Illuminate\Database\Seeder;
use Merodiro\Friendships\Friendship;

class FriendshipsTableSeeder extends Seeder
{
    public function run()
    {
        Friendship::truncate();

        collect([
            [2, 1, 1], [1, 3, 1], [4, 1, 0], [5, 1, 0], [1, 6, 0],
            [2, 6, 1], [2, 7, 1], [2, 8, 1], [2, 9, 1], [2, 10, 1], [2, 11, 1],
            [3, 6, 1], [3, 7, 1], [3, 8, 1], [3, 9, 1], [3, 10, 1], [3, 11, 1],
            [4, 6, 1], [4, 7, 1], [4, 8, 1], [4, 9, 1], [4, 10, 1], [4, 11, 1],
            [5, 6, 1], [5, 7, 1], [5, 8, 1], [5, 9, 1], [5, 10, 1], [5, 11, 1],
        ])->each(function ($values) {
            Friendship::create(
                array_combine(['requester', 'user_requested', 'status'], $values)
            );
        });
    }
}
