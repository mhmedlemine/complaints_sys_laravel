<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupInfractionsTable extends Migration
{
    public function up()
    {
        Schema::create('checkup_infractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkup_id')->constrained();
            $table->foreignId('infraction_id')->constrained();
            $table->text('custom_infraction_text')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkup_infractions');
    }
}