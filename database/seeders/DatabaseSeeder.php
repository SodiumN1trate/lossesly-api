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

        Status::create([
            'name' => 'Nav izskatīts',
            'color' => '#999999',
        ]);

        Status::create([
            'name' => 'Apstiprināts',
            'color' => '#5ed929',
        ]);

        Status::create([
            'name' => 'Sākts',
            'color' => '#f1c232',
        ]);


        Status::create([
            'name' => 'Pabeigts',
            'color' => '#5b5b5b',
        ]);

        Status::create([
            'name' => 'Gaida samaksu',
            'color' => '#FF0000',
        ]);

//        User::factory()->count(1000)->create();
//        UserJob::factory()->count(20)->create();

        UserSpeciality::factory()->count(90)->create();
    }
}
