<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSummonIdToFineTable extends Migration
{
    public function up()
    {
        Schema::table('fines', function (Blueprint $table) {
            $table->foreignId('summon_id')->constrained();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending')->change();
            $table->string('receipt_number');
            $table->date('receipt_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('fines', function (Blueprint $table) {
            $table->dropColumn('summon_id')->constrained();
            $table->string('status');
            $table->dropColumn('receipt_number');
            $table->dropColumn('receipt_date')->nullable();
        });
    }
}