<?php
// database/seeders/TaskSeeder.php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            $categories = $user->categories;
            
            Task::factory(15)->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id ?? null,
            ]);
        });
    }
}
