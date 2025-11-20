<?php

namespace Database\Seeders;

use App\Models\SwDroit;
use App\Models\SwGroupe;
use App\Models\SwUser;
use App\Services\AccessManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SwAccessSeeder extends Seeder
{
    public function run(): void
    {
        // Super admin user
        $admin = SwUser::firstOrCreate(
            ['user_login' => 'admin'],
            [
                'user_nom' => 'Administrateur',
                'user_prenom' => 'QLIO',
                'user_pass_hash' => Hash::make('password'),
                'actif' => 1,
            ]
        );

        $group = SwGroupe::firstOrCreate(
            ['groupe_nom' => 'Administrateurs'],
            [
                'groupe_type' => 5,
                'actif' => 1,
            ]
        );

        $admin->groupes()->syncWithoutDetaching([$group->groupe_id]);

        foreach (array_keys(AccessManager::modules()) as $module) {
            SwDroit::updateOrCreate(
                [
                    'target_type' => 'group',
                    'target_id' => $group->groupe_id,
                    'module' => $module,
                ],
                ['niveau' => 5]
            );
        }
    }
}
