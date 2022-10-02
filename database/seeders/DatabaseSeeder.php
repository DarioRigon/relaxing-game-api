<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $items = [
            [
                'name'=>'Primula',
                'description'=>'Primula L. è un genere di piante della famiglia delle Primulaceae, originario delle zone temperate di Europa, Asia e America.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 100,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.1,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 10
            ],
            [
                'name'=>'Margherita',
                'description'=>'La margherita è una pianta erbacea della famiglia delle Asteraceae, comunissima nei prati della penisola italiana.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 150,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.3,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 20
            ],
            [
                'name'=>'Rosa Bianca',
                'description'=>'La rosa è un genere della famiglia delle Rosacee che comprende circa 150 specie, originarie dell\'Europa e dell\'Asia.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 190,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.4,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 45
            ],
            [
                'name'=>'Rosa Rossa',
                'description'=>'La rosa è un genere della famiglia delle Rosacee che comprende circa 150 specie, originarie dell\'Europa e dell\'Asia.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 350,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.5,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 120
            ],
            [
                'name'=>'Giglio',
                'description'=>'Il giglio è un genere di piante appartenente alla famiglia Liliaceae, diffuso in Europa, Asia e Nord America.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 500,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.65,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 160
            ],
        ];

    foreach($items as $item){
        Item::create($item);
    }
    }
}
