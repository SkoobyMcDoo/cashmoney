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
        Vendor::create(['name' => 'Housekeeper']);
        Vendor::create(['name' => 'Petrol']);
        Vendor::create(['name' => 'Household Expenses and Repair']);
        Vendor::create(['name' => 'Groceries']);
        Vendor::create(['name' => 'Toiletries']);
        Vendor::create(['name' => 'Medical']);
        Vendor::create(['name' => 'Food']);
        Vendor::create(['name' => 'Apparel']);
        Vendor::create(['name' => 'Cosmetics']);
        Vendor::create(['name' => 'Haircare and Aesthetics']);
        Vendor::create(['name' => 'Snacks']);
        Vendor::create(['name' => 'Electronics']);
        Vendor::create(['name' => 'Video Games']);
        Vendor::create(['name' => 'Books and Magazines']);
        Vendor::create(['name' => 'Cinema, Music and Entertainment']);
        Vendor::create(['name' => 'Toys and Collectibles']);
        Vendor::create(['name' => 'Airtime and Data']);
        Vendor::create(['name' => 'Jewellery']);
        Vendor::create(['name' => 'Kitchen Accessories and Utensils']);
        Vendor::create(['name' => 'Travel Expenses']);
    }
}
