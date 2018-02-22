<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('love_likes')->truncate();
        DB::table('love_like_counters')->truncate();
    }
}
