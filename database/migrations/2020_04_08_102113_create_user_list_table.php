<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_list_user', function (Blueprint $table) {

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->bigInteger('shopping_list_id')->unsigned()->index();
            $table->foreign('shopping_list_id')
                ->references('id')->on('shopping_lists')
                ->onDelete('cascade');

            // saves user flag (volunteer or help-seeker)
            // $table->string('user_flag');

            // compounded Primary-Key
            $table->primary(['user_id', 'shopping_list_id']);

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
        Schema::dropIfExists('user_list');
    }
}
