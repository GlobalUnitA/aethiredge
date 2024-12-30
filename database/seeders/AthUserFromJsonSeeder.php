<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;  
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Storage;

class AthUserFromJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/ath_user.json')); 
        $data = json_decode($json, true); 

        foreach ($data as $user) {
            DB::table('ath_user')->insert([
                'user_id' => $user['user_id'],
                'parent_id' => isset($user['parent_id']) ? $user['parent_id'] : null,
                'level' => $user['level'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'meta_uid' => $user['meta_uid'],
                'part_usdt' => $user['part_usdt'],
                'created_at' => $user['created_at'],
            ]);
        }
    }
}