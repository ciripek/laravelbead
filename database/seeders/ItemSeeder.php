<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()
            ->hasAttached(Label::factory()->count(3))
            ->count(20)->create();
    }
}
