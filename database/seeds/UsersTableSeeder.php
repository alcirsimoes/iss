<?php

use App\User;
use App\UserDev;
use App\UserAdmin;
use App\UserSupervisor;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        UserDev::create(['user_id' => $admin->id]);

        $supervisor = User::create([
            'name' => 'Izilda',
            'email' => 'izilda@hvebrasil.com',
            'password' => bcrypt('izilda123')
        ]);
        UserSupervisor::create(['user_id' => $supervisor->id]);

        $entrevistador [] = User::create([
            'name' => 'Cecilia Oliveira',
            'email' => 'mcecilia.oliveira@hotmail.com',
            'password' => bcrypt('972986')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Silvana Jesus',
            'email' => 'silvanacjesus@outlook.com',
            'password' => bcrypt('886298')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Cintia Donadio',
            'email' => 'taina.donadio@uol.com.br',
            'password' => bcrypt('514597')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Jaci Rodrigues',
            'email' => 'jaci.rodrigues@bol.com.br',
            'password' => bcrypt('976581')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Rosana Farina',
            'email' => 'rcfarina44@gmail.com',
            'password' => bcrypt('977879')
        ]);
        $entrevistador [] = User::create([
            'name' => 'katia Mendes',
            'email' => 'kajodura2821@gmail.com',
            'password' => bcrypt('834977')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Claudete Cunha',
            'email' => 'claudete.cunha.2015@gmail.com',
            'password' => bcrypt('227110')
        ]);
        $entrevistador [] = User::create([
            'name' => 'Genilda Saporito',
            'email' => 'janesaporito1@hotmail.com',
            'password' => bcrypt('450559')
        ]);

    }
}
