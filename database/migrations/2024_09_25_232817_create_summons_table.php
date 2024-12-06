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
            $table->foreignId('checkup_id')->constrained();
            $table->enum('status', ['pending', 'fined', 'completed', 'appealed']);
            $table->timestamp('filledon');
            $table->foreignId('agent_id')->constrained('users');
            $table->foreignId('entreprise_id')->constrained();
            $table->date('duedate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('summons');
    }
}