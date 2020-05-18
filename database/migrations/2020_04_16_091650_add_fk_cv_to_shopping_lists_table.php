<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkCvToShoppingListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->bigInteger('creator_id')->unsigned()->index();
            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->bigInteger('volunteer_id')->unsigned()->index()->nullable();
            $table->foreign('volunteer_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->dropForeign(['volunteer_id']);
        });
    }
}
