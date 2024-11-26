<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckupIdToComplaintTable extends Migration
{
    public function up()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('checkup_id')->constrained();
            $table->dropForeign(['investigator_agent_id']);
            $table->dropColumn('investigator_agent_id');
            $table->dropColumn('status');
        });
    }

    public function down()
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('checkup_id');
            $table->string('status');
            $table->foreignId('investigator_agent_id')->constrained('users')->nullable();
        });
    }
}