<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categorie::insert([
            ['title' => 'Writing Instruments'],
            ['title' => 'Paper Products'],
            ['title' => 'Office Supplies'],
            ['title' => 'Filing & Organization'],
            ['title' => 'Desk Accessories'],
            ['title' => 'Art Supplies'],
            ['title' => 'Presentation Supplies'],
            ['title' => 'Technology Accessories'],
            ['title' => 'Breakroom Supplies']
        ]);
    }
}
