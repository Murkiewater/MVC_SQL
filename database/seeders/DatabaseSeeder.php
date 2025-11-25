<?php

namespace Database\Seeders;

use App\Models\Users;
use App\Models\Friends;
use App\Models\Groups;
use App\Models\PostInGroups;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Users::factory()->create([
            'full_name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => '$2y$10$b6AHpXuHCajccfdonZaoruUoajaCkzAEL81g0gSAEl9uMCR1sScL6',
        ]);
        
        Users::factory(10)->create();

        Groups::insert([
            ['name' => 'Администраторы'],
            ['name' => 'Модераторы'],
            ['name' => 'Пользователи'],
            ['name' => 'Гости'],
        ]);

        $users = Users::all();
        $allGroups = Groups::all();

        foreach ($users as $user) {
            $user->groups()->attach(
                $allGroups->random(rand(1, 3))->pluck('id')->toArray()
            );
            
            $possibleFriends = $users->where('id', '!=', $user->id);
            $randomFriends = $possibleFriends->random(min(rand(1, 3), $possibleFriends->count()));
    
            foreach ($randomFriends as $f) {
                $user1 = min($user->id, $f->id);
                $user2 = max($user->id, $f->id);
    
                Friends::updateOrCreate(
                    [
                        'user1_id' => $user1,
                        'user2_id' => $user2,
                    ],
                    [
                        'date_of_friendship' => now(),
                    ]
                );
            }
        }
        
        foreach ($allGroups as $group) {
            $memberIds = $group->users()->pluck('users.id');
            for ($i = 0; $i < rand(3, 8); $i++) {
                if ($memberIds->isEmpty()) break;

                $authorId = $memberIds->random();

                PostInGroups::create([
                    'user_id'      => $authorId,
                    'group_id'     => $group->id,
                    'text'         => fake()->realText(rand(60, 140)),
                    'date_of_post' => now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440)),
                ]);
            }
        }

        PostInGroups::create([
            'user_id'      => 1,
            'group_id'     => 2,
            'text'         => 'над этим постом проводятся махинации',
            'date_of_post' => now(),
        ]);
        
        PostInGroups::firstOrCreate([
            'user_id' => 1,
            'group_id' => 2,
            'text' => 'Всем привет, я жертва бета-теста',
            'date_of_post' => now(),
        ]);
    }
}
