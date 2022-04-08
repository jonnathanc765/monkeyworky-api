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
        VariationSize::create(['size' => 'Tarro']);
        VariationSize::create(['size' => 'Litro']);
        VariationSize::create(['size' => 'Galon']);
        VariationSize::create(['size' => 'Paila']);
        VariationSize::create(['size' => 'Tambor']);
        VariationSize::create(['size' => 'Totem']);
    }
}
