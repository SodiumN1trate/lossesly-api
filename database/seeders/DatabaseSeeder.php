<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Status;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserSpeciality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::create([
//            'name' => 'Renārs',
//            'surname' => 'Gausiņš',
//            'email' => 'renarsgausins21@gmail.com',
//            'password' => Hash::make('qwertyuiop'),
//        ]);
//
//        User::create([
//            'name' => 'Tests',
//            'surname' => 'Tests',
//            'email' => 'qwerty@gmail.com',
//            'password' => Hash::make('qwertuyiop'),
//        ]);
//
//        Status::create([
//           'name' => 'Pabeigts',
//        ]);

//        UserJob::factory()->count(100)->create();
//
//        User::factory()->count(100)->create();
        UserSpeciality::factory()->count(100)->create();
    }
}
