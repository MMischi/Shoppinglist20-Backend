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
        Schema::create('list_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->integer('amount');
            $table->string('extra_info')->nullable();
            $table->float('max_price');

            $table->bigInteger('shopping_list_id')->unsigned()->index()->nullable();
            $table->foreign('shopping_list_id')
                ->references('id')->on('shopping_lists')
                ->onDelete('cascade');

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
        Schema::dropIfExists('list_items');
    }
}
