<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummonsTable extends Migration
{
    public function up()
    {
        Schema::create('summons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('status');
            $table->dateTime('filledon');
            $table->foreignId('agent_id')->constrained('users');
            $table->foreignId('complaint_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->text('action');
            $table->date('duedate');
            // $table->foreignId('infraction_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('summons');
    }
}