<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //add data: save(), create(),insert()

        $categories = [
           [
                 'name' => 'Theatre',
                 'updated_at' => NOW(),
                 'created_at' => NOW()
           ],
           [
                 'name' => 'Entertainment',
                 'updated_at' => NOW(),
                 'created_at' => NOW()
           ],
           [
                 'name' => 'Current Events',
                 'updated_at' => NOW(),
                 'created_at' => NOW()
           ]
        ];

        Category::insert($categories);
    }
}
