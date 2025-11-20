<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SwTypeStage;

class SwTypeStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['typsta_libelle' => 'Stage de découverte', 'typsta_obs' => 'Stage d\'observation en entreprise'],
            ['typsta_libelle' => 'Stage de fin d\'études', 'typsta_obs' => 'Stage obligatoire pour l\'obtention du diplôme'],
            ['typsta_libelle' => 'Stage alterné', 'typsta_obs' => 'Stage en alternance avec formation'],
            ['typsta_libelle' => 'Stage technique', 'typsta_obs' => 'Stage à dominante technique'],
            ['typsta_libelle' => 'Stage commercial', 'typsta_obs' => 'Stage à orientation commerciale'],
        ];

        foreach ($types as $type) {
            SwTypeStage::create($type);
        }
    }
}
