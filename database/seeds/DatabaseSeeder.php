<?php

use App\User;
use App\UserAdmin;
use App\UserSupervisor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Alcir Simões de Oliveira',
            'email' => 'alcirsimoes@gmail.com',
            'password' => bcrypt('alcir123')
        ]);

        UserAdmin::create(['user_id' => $admin->id]);

        $supervisor = User::create([
            'name' => 'Izilda',
            'email' => 'izilda@hvebrasil.com',
            'password' => bcrypt('izilda123')
        ]);

        UserSupervisor::create(['user_id' => $supervisor->id]);
        // $this->call(UsersTableSeeder::class);
    }
}
