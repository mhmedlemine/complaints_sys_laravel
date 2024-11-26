<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupsTable extends Migration
{
    public function up()
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('agent_id')->nullable()->constrained('users');
            $table->foreignId('entreprise_id')->constrained();
            $table->foreignId('complaint_id')->nullable()->constrained();
            $table->datetime('date')->nullable();
            $table->enum('status', ['pending', 'clean', 'with_infractions'])->default('pending');
            $table->enum('type', ['regular', 'complaint']);
            $table->enum('action_taken', ['none', 'closed'])->default('none');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkups');
    }
}