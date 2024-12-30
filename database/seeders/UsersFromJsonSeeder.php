<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;  
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;

class UsersFromJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/users.json')); 
        $data = json_decode($json, true); 

        foreach ($data as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'account' => $user['account'],
                'password' => Hash::make($user['password']), 
                'created_at' => $user['created_at'],
                'updated_at' => $user['created_at'],
            ]);
        }
    }
}
