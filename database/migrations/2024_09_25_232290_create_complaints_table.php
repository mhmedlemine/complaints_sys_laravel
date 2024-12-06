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
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('greenNumber');
            $table->foreignId('consumer_id')->constrained();
            $table->foreignId('receiving_agent_id')->constrained('users');
            $table->foreignId('moughataa_id')->constrained();
            $table->foreignId('entreprise_id')->nullable()->constrained();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->enum('status', ['pending', 'assigned', 'investigating', 'resolved']);
            $table->string('shop_address');
            $table->boolean('is_valid')->default(true);
            $table->timestamp('reported_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}