<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        // Ensure that the subjects table is created first
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
        });

        // Now create the questions table with foreign keyss
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 1023);
            $table->enum('question_type', ['multiple_choice', 'open_ended']);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Create other tables after questions to reference them correctly
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
    public function down() : void
    {
        // Drop dependent tables first
        Schema::dropIfExists('options_history');
        Schema::dropIfExists('options');

        // Now drop other tables like questions, answers, etc.
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('subjects');
    }
};
