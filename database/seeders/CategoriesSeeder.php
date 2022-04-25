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
        $category = Category::create(['name' => 'MUGS', 'picture' => 'categories/mugs.svg']);
        $category->subCategories()->create(['name' => 'MUGS']);

        $category = Category::create(['name' => 'NERDSTUFF', 'picture' => 'categories/nerdstuff.svg']);
        $category->subCategories()->create(['name' => 'NERDSTUFF']);

        $category = Category::create(['name' => 'OFFICE', 'picture' => 'categories/office.svg']);
        $category->subCategories()->create(['name' => 'OFFICE']);

        $category = Category::create(['name' => 'PHONE', 'picture' => 'categories/phone.svg']);
        $category->subCategories()->create(['name' => 'PHONE']);

        $category = Category::create(['name' => 'SHIRTS', 'picture' => 'categories/shirts.svg']);
        $category->subCategories()->create(['name' => 'SHIRTS']);
    }
}
