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
            $table->integer('owner_id')->constrained('users');
            $table->integer('subject_id')->constrained('subjects');
            $table->integer('poll_id')->constrained('polls');
            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->constrained('questions');
            $table->longText('user_text');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->integer('question_id')->constrained('questions');
            $table->string('option_text', 511);
            $table->tinyInteger('correct');
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
        });

        Schema::create('options_history', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('times_answered');
            $table->integer('option_id')->constrained('options');
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
