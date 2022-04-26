<?php

namespace Database\Seeders;

use App\Models\VariationSize;
use Illuminate\Database\Seeder;

class VariationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VariationSize::create(['size' => 'Small']);
        VariationSize::create(['size' => 'Medium']);
        VariationSize::create(['size' => 'Large']);
    }
}
