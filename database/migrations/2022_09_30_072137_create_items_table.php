<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', array('flower', 'tree', 'vegetable','fruit','misc'));
            $table->enum('rarity', array('common', 'uncommon', 'rare','leggendary'));
            $table->string('image_url')->nullable();
            $table->double('cost',15,2);
            $table->enum('cost_currency', array('bills', 'gems', 'stars','euro'));
            $table->double('roi_per_second',15,2);
            $table->enum('roi_currency', array('bills', 'gems', 'stars','euro'));
            $table->integer('max_gain');
            $table->integer('time_to_bloom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
