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
            $table->foreignId('entreprise_id')->nullable()->constrained();
            $table->foreignId('complaint_id')->nullable()->constrained();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'clean', 'with_infractions', 'canceled'])->default('pending');
            $table->enum('type', ['regular', 'complaint']);
            $table->enum('investigation_result', ['all_confirmed', 'all_false', 'partially_confirmed'])->nullable();
            $table->enum('action_taken', ['none', 'closed', 'summon_issued'])->default('none');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkups');
    }
}