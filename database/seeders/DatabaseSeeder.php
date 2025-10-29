<?php

namespace Database\Seeders;

use App\Models\Users;
use App\Models\Friends;
use App\Models\Groups;
use App\Models\PostInGroups;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Users::factory(3)->create();

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
        
        PostInGroups::create([
            'user_id' => 1,
            'group_id' => 2,
            'text' => 'Всем привет, я жертва бета-теста',
            'date_of_post' => now(),
        ]);
    }
}
