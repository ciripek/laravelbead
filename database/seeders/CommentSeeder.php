<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $items = Item::all();

        for($i = 0; $i < 100; ++$i){
            Comment::factory()
                ->for($users->random())
                ->for($items->random())
                ->create();
        }

    }
}
