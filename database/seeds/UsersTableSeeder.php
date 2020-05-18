<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user1 = new App\User;
        $user1->firstName = 'Michelle';
        $user1->lastName = 'Markl';
        $user1->email = 'user1@test.at';
        $user1->password = bcrypt('user1');
        $user1->flag = 'volunteer';

        $addressUser1 = App\Address::all();
        $user1->address()->associate($addressUser1[1]);

        $user1->save();


        $user2 = new App\User;
        $user2->firstName = 'Gertraud';
        $user2->lastName = 'Unger';
        $user2->email = 'user2@test.at';
        $user2->password = bcrypt('user2');
        $user2->flag = 'help-seeker';

        $addressUser2 = App\Address::all();
        $user2->address()->associate($addressUser2[0]);

        $user2->save();

        $user3 = new App\User;
        $user3->firstName = 'Florian';
        $user3->lastName = 'Mostofi';
        $user3->email = 'user3@test.at';
        $user3->password = bcrypt('user3');
        $user3->flag = 'volunteer';

        $addressUser3 = App\Address::all();
        $user3->address()->associate($addressUser3[1]);

        $user3->save();


    }
}
