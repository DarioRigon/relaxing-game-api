<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Item;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->inventories;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return "here we are";

        $data = $request->validate([
            'item_id'=>'integer'
        ]);

        

        $item = Item::find($data['item_id']);

        $user = auth()->user();

        //find how much the items costs.
        $cname = $item->cost_currency;
        $cost = $item->cost;

        //find if user has the money to buy it.
        if($user->wallet->$cname >= $cost){

            //if he has let's take the money:
            $user->wallet->$cname = $user->wallet->$cname - $cost;
            $user->wallet->save();

            //checks if user already has the item in a inventory:
            $inventory = $user->inventories()->where('item_id',$item->id)->first();
            
            //if he doesnt have it, let's create the inventory for that item:
            if(!$inventory){
                $user->inventories()->create(['item_id'=> $item->id, 'amount'=> 1]);
            }else{
                $inventory->amount = $inventory->amount+1;
                $inventory->save();
            }

            return response([
                
            'message' => 'Item bought.',
                
            $user->inventories,
            
            'money' => [
                'bills'=>$user->wallet->bills, 
                'stars'=>$user->wallet->stars, 
                'gems'=>$user->wallet->gems,
                'euros'=> $user->wallet->euros
                ]
            
            ],200);

        }

        return response([
            'message' => 'Not enough money',
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
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
