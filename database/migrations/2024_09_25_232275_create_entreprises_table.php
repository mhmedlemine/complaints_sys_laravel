<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('contact_number')->nullable();
            $table->json('picture')->nullable();
            $table->foreignId('moughataa_id')->constrained();
            $table->foreignId('owner_id')->constrained('merchants');
            $table->enum('status', ['open', 'summoned', 'closed']);
            $table->string('type');
            $table->timestamp('registeredon');
            $table->foreignId('agent_id')->constrained('users');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->string('rg')->nullable();
            $table->text('notes')->nullable();
            $table->text('address')->nullable();
            $table->json('evidence_files')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->string('agentname')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
}