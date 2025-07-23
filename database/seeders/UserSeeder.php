<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Frank',
                'email' => 'frank@mail.com',
                'password' => Hash::make('pass1234'),
                'role_id' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Gina',
                'email' => 'gina@mail.com',
                'password' => Hash::make('pass1234'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Hank',
                'email' => 'hank@mail.com',
                'password' => Hash::make('pass1234'),
                'role_id' => 2,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ];

        User::insert($users);
    }
}











