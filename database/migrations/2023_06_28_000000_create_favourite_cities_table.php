<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouriteCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourite_cities', function (Blueprint $table) {
            // Field Creation
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->float('lat');
            $table->float('lon');
            $table->string('country');
            $table->string('state');
            $table->timestamps();

            // Index Creation
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourite_cities');
    }
}
