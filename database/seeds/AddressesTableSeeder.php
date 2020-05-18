<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address1 = new App\Address;
        $address1->street = 'Feldgasse';
        $address1->house_number = 31;
        $address1->post_code = 2100;
        $address1->place = 'Korneuburg';
        $address1->country = 'Austria';
        $address1->save();

        $address2 = new App\Address;
        $address2->street = 'Herzgasse';
        $address2->house_number = 5;
        $address2->post_code = 1100;
        $address2->place = 'Wien';
        $address2->country = 'Austria';
        $address2->save();

    }
}
