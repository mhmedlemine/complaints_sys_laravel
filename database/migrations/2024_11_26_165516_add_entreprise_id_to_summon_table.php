<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntrepriseIdToSummonTable extends Migration
{
    public function up()
    {
        Schema::table('summons', function (Blueprint $table) {
            $table->foreignId('entreprise_id')->constrained();
        });
    }

    public function down()
    {
        Schema::table('summons', function (Blueprint $table) {
            $table->dropForeign(['entreprise_id']);
            $table->dropColumn('entreprise_id');
        });
    }
}