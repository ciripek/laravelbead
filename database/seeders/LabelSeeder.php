<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    public function run()
    {
        Label::factory()
            ->hasAttached(Item::factory()->count(10))
            ->count(3)->create();
    }
}
