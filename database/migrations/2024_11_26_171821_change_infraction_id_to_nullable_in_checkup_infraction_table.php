<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInfractionIdToNullableInCheckupInfractionTable extends Migration
{
    public function up()
    {
        Schema::table('checkup_infractions', function (Blueprint $table) {
            $table->foreignId('infraction_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('checkup_infractions', function (Blueprint $table) {
            $table->foreignId('infraction_id')->constrained();
        });
    }
}