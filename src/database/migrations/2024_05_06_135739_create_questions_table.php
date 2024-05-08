<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 1023);
            $table->enum('question_type', ['multiple_choice', 'open_ended']);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('poll_id')->constrained('polls');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('user_text');
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->string('option_text', 511);
            $table->boolean('correct')->default(false);
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
        });

        Schema::create('options_history', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('times_answered')->unsigned();
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('options');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('options_history');
    }
};
