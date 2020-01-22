<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('controller')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('abilitables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('abilitable');
            $table->unsignedBigInteger('ability_id')->index();
            $table->text('meta')->nullable();
            // $table->morphs('abilitable');
            // $table->unsignedBigInteger('user_id')->index();
        });

        Schema::create('group_abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('user_group_abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('user_group_id')->index();
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
        Schema::dropIfExists('abilities');
        Schema::dropIfExists('abilitables');
        Schema::dropIfExists('group_abilities');
        Schema::dropIfExists('user_group_abilities');
    }
}
