<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckupIdToSummonsTable extends Migration
{
    public function up()
    {
        Schema::table('summons', function (Blueprint $table) {
            $table->foreignId('checkup_id')->constrained();
            $table->enum('status', ['pending', 'fined', 'completed'])->default('pending')->change();
            $table->dropForeign(['complaint_id']);
            $table->dropColumn('complaint_id');
        });
    }

    public function down()
    {
        Schema::table('summons', function (Blueprint $table) {
            $table->dropColumn('checkup_id');
            $table->string('status');
            $table->foreignId('complaint_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
}