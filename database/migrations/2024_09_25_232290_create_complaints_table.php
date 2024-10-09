<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('greenNumber');
            $table->foreignId('consumer_id')->constrained('consumers');
            $table->dateTime('filledon');
            $table->foreignId('receiver_agent_id')->constrained('users');
            $table->foreignId('investigator_agent_id')->constrained('users')->nullable();
            $table->string('type');
            $table->foreignId('entreprise_id')->constrained();
            $table->string('status');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}