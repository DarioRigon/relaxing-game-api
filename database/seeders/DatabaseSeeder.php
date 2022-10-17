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
                'roi_per_second'=> 0.01,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 10
            ],
            [
                'name'=>'Margherita',
                'description'=>'La margherita è una pianta erbacea della famiglia delle Asteraceae, comunissima nei prati della penisola italiana.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 1500,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.02,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 200
            ],
            [
                'name'=>'Rosa Bianca',
                'description'=>'La rosa è un genere della famiglia delle Rosacee che comprende circa 150 specie, originarie dell\'Europa e dell\'Asia.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 3900,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.03,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 800
            ],
            [
                'name'=>'Rosa Rossa',
                'description'=>'La rosa è un genere della famiglia delle Rosacee che comprende circa 150 specie, originarie dell\'Europa e dell\'Asia.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 9000,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.05,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 2000
            ],
            [
                'name'=>'Giglio',
                'description'=>'Il giglio è un genere di piante appartenente alla famiglia Liliaceae, diffuso in Europa, Asia e Nord America.',
                'type'=>'flower',
                'rarity'=>'common',
                'cost'=> 15000,
                'cost_currency'=> 'bills',
                'roi_per_second'=> 0.06,
                'roi_currency'=> 'bills',
                'time_to_bloom'=> 4300
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
                $cost = $i * 3500 + ($i*600);
                $cname = 'bills';
                break;

            case $i > 25 && $i <= 50:
                    $cost = $i * 4500 + ($i*900);
                    $cname = 'stars';
                break;

            case $i > 50 && $i <= 69:
                    $cost = $i * 5500 + ($i*1500);
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
