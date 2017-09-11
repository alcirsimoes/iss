<?php

use App\User;
use App\UserAdmin;
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
        $user = User::create([
            'name' => 'Alcir Simões de Oliveira',
            'email' => 'alcirsimoes@gmail.com',
            'password' => bcrypt('alcir123')
        ]);

        UserAdmin::create(['user_id' => $user->id]);
        // $this->call(UsersTableSeeder::class);
    }
}
