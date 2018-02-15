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
            "Andrew__Huggins__andrewhuggins@gmail.com__",
            "Andrey__Shilov__andrey.dry7.shilov@yandex.ru__",
            "Bobby__Bouwmann__bobbybouwmann@gmail.com__",
            "Davor__Minchorov__davorminchorov@gmail.com__",
            "Ed__Del Monico__ejdelmonico@gmail.com__",
            "Jonathan__Bernardi__spekkionu@spekkionu.com__",
            "Mark__Snape__mark@novate.co.uk__",
            "Michael__Dyrynda__michael@dyrynda.com.au__",
            "Mick__Byrne__phpMick@gmail.com__",
            "Narciso__Arias__narciso.arias21@gmail.com__",
            "Paul__Finch__finchy70@gmail.com__",
            "Pierre__Mallinjoud__pierre.mallinjoud@gmail.com__",
            "Ryan__Bobrowski__ryan.bobrowski@gmail.com__",
            "Tim__Pietrusky__heyho@timpietrusky.com__",
            "Tyler__O'Donnell__tyler@tylerodonnell.com__",
            "Will__Vincent__will@willvincent.com__",
            "Zach__Leigh__zachleigh@fastmail.jp__",
        ];

        foreach ($users as $user) {
            [$firstname, $lastname, $email, $location] = explode('__', $user);
            $username = explode('@', $email)[0];
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
