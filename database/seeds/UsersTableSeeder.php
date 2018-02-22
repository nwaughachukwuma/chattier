<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        $users = [
            "Ranie__Santos__ranie@gmail.com__Manila, PH",
            "Alex__Garrett__alex@codecourse.com__London, UK",
            "Bucky__Roberts__buckyroberts@gmail.com__",
            "Caleb__Porzio__calebporzio@gmail.com__",
            "Dayle__Rees__me@daylerees.com__",
            "Eric__Barnes__eric@ericlbarnes.com__",
            "Freek__Van der Herten__freek@spatie.be__",
            "Gary__Servin__gary@ekumenlabs.com__",
            "Henry__Garner__henry@henrygarner.com__",
            "Ian__Obermiller__ian@obermillers.com__",
            "Jeffrey__Way__jeffrey@laracasts.com__",
            "Kevin__Suttle__kevin@suttle.email__",
            "Larry__Marburger__larry@marburger.cc__",
            "Michael__Dyrynda__michael@dyrynda.com.au__",
            "Natalie__Greco__natalie@otakuchick.com__",
            "Oscar__Del Ben__oscar@oscardelben.com__",
            "Paul__Redmond__paulrredmond@gmail.com__",
            "Quinn__Neumiiller__quinn@neumiiller.com__",
            "Rob__Reynolds__ferventcoder@gmail.com__",
            "Sean__Tymon__tymon148@gmail.com__",
            "Taylor__Otwell__taylor@laravel.com__",
            "Ulysses__Bonfim__ulyssesb@gmail.com__",
            "Victor__Berchet__victor@suumit.com__",
            "Will__Vincent__will@willvincent.com__",
            "Xavier__Lacot__xavier@lacot.org__",
            "Yves__Raimond__yves@dbtune.org__",
            "Zach__Leigh__zachleigh@fastmail.jp__",
        ];

        foreach ($users as $user) {
            [$firstname, $lastname, $email, $location] = explode('__', $user);
            $username = strtolower($firstname);
            $password = 'password';
            $location = (empty($location) ? null : $location);

            User::create(compact(
                'email',
                'username',
                'password',
                'firstname',
                'lastname',
                'location'
            ));
        }
    }
}
