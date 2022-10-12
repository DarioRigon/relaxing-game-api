<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Item;
use App\Models\FieldPrice;
use Illuminate\Http\Request;
use DateTime;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->fields;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = auth()->user();
        $count = $user->fields()->count();
        $currency = null;
        $cname = null;

        $fieldPrice = FieldPrice::Find($count+1);

        //how much does the field cost?
        $cost = $fieldPrice->amount;
        //what kind of money do you need?
        $cname = $fieldPrice->currency;
        //how much does the use have?
        $currency = $user->wallet->$cname;

        /*switch(true){
            case $count > 0 && $count <= 25:
                $currency = $user->wallet->bills;
                $cost = $count * 350;
                $cname = 'bills';
                break;

            case $count > 25 && $count <= 50:
                    $currency = $user->wallet->stars;
                    $cost = $count * 450;
                    $cname = 'stars';
                break;

            case $count > 50 && $count <= 75:
                    $currency = $user->wallet->gems;
                    $cost = $count * 550;
                    $cname = 'gems';
            break;

            case $count > 75:
                $currency = $user->wallet->euros;
                $cost = $count * 0.5;
                $cname = 'euros';
            break;
                
        }*/
        
        if( $currency >= $cost){
            $user->fields()->create();
            $user->wallet()->update([$cname => $user->wallet->$cname - $cost]);
            return response(
                [
                'exit'=> 1,
                'message' => 'Terreno acquistato.',
                'cost'=> $cost,
                'currency'=>$cname,
                $user->fields
                ],201);
        }

        return response([
            'exit'=> 0,
            'message' => 'Non hai abbastanza crediti.',
            'cost' => $cost,
            'currency' => $cname,
            'money' => [
                'bills'=>$user->wallet->bills, 
                'stars'=>$user->wallet->stars, 
                'gems'=>$user->wallet->gems,
                'euros'=> $user->wallet->euros
                ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
            return $field;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $user = auth()->user();

        $data = $request->validate([
            'action'=>'string',
            'item_id'=>'integer|nullable'
        ]); 

        $fieldIsYours = $user->id == $field->user_id;

        if(!$fieldIsYours){
            return response ([
                'exit'=>0,
                'message'=>'Il terreno non è tuo.'
            ]);
        }

        if($data['action'] == 'plant'){

            if($field->item_id != null){
                return response([
                    'exit'=> 0,
                    'message'=>'Spiacente. Il terreno non è vuoto.',
                ]);
            }

            $item = Item::find($data['item_id']);

            if(!$item){
                return response(['message'=>'Item doesn\'t exist']);
            }

            $inventory = $user->inventories()->where('item_id', $data['item_id'])->first();

            if(!$inventory || !$inventory->amount){
                return response([
                    'exit'=> 0,
                    'message'=>'Oggetto esaurito.'
                ]);
            }

            $inventory->amount = $inventory->amount -1;
            $inventory->save();

            $field->item_id = $data['item_id'];
            $time = new DateTime();
            $field->time_to_bloom = $time->modify('+' .$item->time_to_bloom . ' seconds');
            $field->save();

            return response([
                    'exit'=> 1,
                    'message'=>'Oggetto piantato con successo.',
                    $field,
                ]
            );
        }

        if($data['action'] == 'gain'){

            $item = Item::find($field->item_id);

            if(!$item){
                return response([
                    'exit'=> 0,
                    'message'=> 'Non puoi guadagnare. Il terreno è vuoto.'
                ]);
            }

            $fieldBloomTime = new DateTime($field->time_to_bloom);
            $currentTime = new DateTime();

            $hasBloom = $fieldBloomTime < $currentTime;

            if($hasBloom){
                
                //if it is the first time gaining
                if($field->gain_time == null){
                    $field->gain_time = $field->time_to_bloom;
                    $field->save();
                }

                //let's gain some cash!
                $fieldGainTime = new DateTime($field->gain_time);
                $seconds = $currentTime->getTimestamp() - $fieldGainTime->getTimestamp();
                $amountGained = $item->roi_per_second * (double)$seconds;
                $currency = $item->roi_currency;
                $user->wallet->$currency = $user->wallet->$currency + $amountGained;
                $user->wallet->save();

                //let's lock in the gain time
                $field->gain_time = $currentTime;
                $field->save();

                return response([
                    'exit'=> 1,
                    'message'=> 'Hai guadagnato',
                    'amount'=> $amountGained,
                    'currency'=> $currency,
                    'wallet_amount'=> $user->wallet->$currency,
                    'time'=> $seconds
                ]);
            }

            return response([
                'exit'=> 0,
                'message'=> 'Non puoi ancora guadagnare.',
                'planted'=> $fieldBloomTime - $currentTime
            ]);
        }

        if($data['action'] == 'remove'){

            $inventory = $user->inventories()->where('item_id', $field->item_id)->first();
            $inventory->amount = $inventory->amount +1;
            $inventory->save();
            $field->item_id = null;
            $field->time_to_bloom = null;
            $field->gain_time = null;
            $field->save();

            return response([
                'exit'=> 1,
                'message'=> 'Oggetto rimosso dal terreno.',
                'current_amount'=> $inventory->amount
            ]);

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        return response([
            'exit'=> 0,
            'message'=>'Azione non consentita.'
        ], 401);
    }
}
