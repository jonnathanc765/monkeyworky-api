<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'VEHÍCULOS']);
        $category->subCategories()->create(['name' => 'SINTETICO']);
        $category->subCategories()->create(['name' => 'SEMISINTETICO']);
        $category->subCategories()->create(['name' => 'MINERAL']);

        $category = Category::create(['name' => 'MOTOS']);
        $category->subCategories()->create(['name' => '4 TIEMPOS']);
        $category->subCategories()->create(['name' => '2 TIEMPOS MINERAL']);
        $category->subCategories()->create(['name' => '2 TEIMPOS SEMISINTETICO']);

        $category = Category::create(['name' => 'MARINOS']);
        $category->subCategories()->create(['name' => 'MARINOS']);

        $category = Category::create(['name' => 'TRANSMISIONES']);
        $category->subCategories()->create(['name' => 'AUTOMATICA']);
        $category->subCategories()->create(['name' => 'MANUALES']);

        $category = Category::create(['name' => 'INDUSTRIALES']);
        $category->subCategories()->create(['name' => 'INDUSTRIALES']);


        $category = Category::create(['name' => 'MANTENIMIENTO']);
        $category->subCategories()->create(['name' => 'GRASAS']);
        $category->subCategories()->create(['name' => 'LIMPIEZA']);
        $category->subCategories()->create(['name' => 'REFRIGERANTES']);
        $category->subCategories()->create(['name' => 'LIGA DE FRENOS']);

        $category = Category::create(['name' => 'MOTORES A GAS']);
        $category->subCategories()->create(['name' => 'MINERAL']);

    }
}
