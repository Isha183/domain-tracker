<?php

namespace Database\Seeders;

use App\Models\Email;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(){
        
        Email::create([
            'email' => 'abc@gmail.com',
            'days' => 15
        ]);
        Email::create([
            'email' => 'xyz@gmail.com',
            'days' => 20
        ]);
    }
    
}
