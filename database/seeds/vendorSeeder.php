<?php

use Illuminate\Database\Seeder;
use App\Vendor;

class vendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create(['name' => 'Petrol']);
        Vendor::create(['name' => 'Checkers']);
        Vendor::create(['name' => 'Woolworths']);
        Vendor::create(['name' => 'Spar']);
        Vendor::create(['name' => 'Pick n Pay']);
        Vendor::create(['name' => 'Zara']);
        Vendor::create(['name' => 'H&M']);
        Vendor::create(['name' => 'Dischem']);
        Vendor::create(['name' => 'Clicks']);
        Vendor::create(['name' => 'Khans']);
        Vendor::create(['name' => 'Aramex Global Shopper']);
        Vendor::create(['name' => 'ColourPop']);
        Vendor::create(['name' => 'Glossier']);
    }
}
