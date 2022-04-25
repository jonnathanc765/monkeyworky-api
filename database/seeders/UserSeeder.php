<?php

namespace Database\Seeders;

use App\Models\People;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $people = People::create([
            'firstname' => 'Admin',
            'lastname' => 'Monkey',
            'state_id' => 13,
        ]);

        $user = $people->user()->create([
            'email' => 'admin@monkeyworky.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(Role::findByName('admin'));
    }
}
