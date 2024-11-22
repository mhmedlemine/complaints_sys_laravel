<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeEnterpriseNeighbourhoodToMoughataa extends Migration
{
    public function up()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropForeign(['neighbourhood_id']);
            $table->dropColumn('neighbourhood_id');
            
            $table->string('neighbourhood')->nullable();
            $table->string('agentname')->nullable();
            $table->unsignedBigInteger('moughataa_id');
            $table->foreign('moughataa_id')->references('id')->on('moughataas');
        });
    }

    public function down()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn('neighbourhood');
            $table->dropColumn('agentname');
            
            $table->unsignedBigInteger('neighbourhood_id');
            $table->foreign('neighbourhood_id')->references('id')->on('neighbourhoods');
        });
    }
}