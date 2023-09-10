<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create(['name' => 'MUGS']);
        $filePath = public_path('images/categories/mugs.svg');
        $file = new UploadedFile($filePath, 'mugs.svg', 'image/svg', null, true);
        $category->picture()->create([])->attach($file);
        $category->subCategories()->create(['name' => 'Mugs']);
    }
}
