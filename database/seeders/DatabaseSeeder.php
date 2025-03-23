<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        ItemCategory::factory(20)->create();
        Item::factory(50)->create();
    }
}