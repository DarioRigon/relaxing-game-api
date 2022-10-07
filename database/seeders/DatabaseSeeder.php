<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\FieldPrice;

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
                'roi_per_second'=> 0.06,
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
                'roi_per_second'=> 0.08,
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
                'roi_per_second'=> 0.1,
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
                'roi_per_second'=> 0.12,
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
                'roi_per_second'=> 0.15,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 160
            ],
        ];

    foreach($items as $item){
        Item::create($item);
    }

    for($i = 0; $i < 100; $i++){
        switch($i){
            case $i == 0:
                $cname = 'bills';
                $cost = 0;
                break;

            case $i > 0 && $i <= 25:
                $cost = $i * 350 + ($i*200);
                $cname = 'bills';
                break;

            case $i > 25 && $i <= 50:
                    $cost = $i * 450 + ($i*200);
                    $cname = 'stars';
                break;

            case $i > 50 && $i <= 69:
                    $cost = $i * 550 + ($i*200);
                    $cname = 'gems';
            break;

            case $i > 70:
                $cost = (0.5 * $i/50);
                $cname = 'euro';
            break;
                
        }
        FieldPrice::create(['currency'=>"$cname",'amount'=>$cost]);
    }


    }
}
