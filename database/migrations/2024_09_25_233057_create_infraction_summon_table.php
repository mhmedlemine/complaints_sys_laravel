<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfractionSummonTable extends Migration
{
    public function up()
    {
        Schema::create('infraction_summon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('summon_id');
            $table->unsignedBigInteger('infraction_id');
            $table->timestamps();

            $table->foreign('summon_id')->references('id')->on('summons')->onDelete('cascade');
            $table->foreign('infraction_id')->references('id')->on('infractions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('infraction_summon');
    }
}