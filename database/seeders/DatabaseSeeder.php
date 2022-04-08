<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(StateSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(DeliveryManagamentSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(VariationsSeeder::class);
    }
}
