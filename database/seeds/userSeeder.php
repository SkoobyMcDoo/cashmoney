<?php

use Illuminate\Database\Seeder;
use App\User;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create( [
            'email' => 'app@cash-money.co.za' ,
            'password' => Hash::make( 'hrBf37zqDyKw6sV' ) ,
            'name' => 'CashMoney App'
        ] );
    }
}
