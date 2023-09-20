<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $n = rand(5, 10);

        for ($i = 1; $i <= $n; $i++){
            User::factory()
                ->create(
                ['email' => 'user' . $i .'@szerveroldali.hu']
            );
        }

        User::factory()->create([
            "name" => "admin",
            "email" => "admin@szerveroldali.hu",
            "password" => Hash::make("adminpwd"),
            "is_admin" => true
        ]);
    }
}
