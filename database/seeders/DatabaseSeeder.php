<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App;

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

        if (!app()->environment(['production'])) {
            $this->call(CategoriesSeeder::class);
            $this->call(DeliveryManagamentSeeder::class);
            $this->call(BankSeeder::class);
            $this->call(VariationsSeeder::class);
        }
    }
}
