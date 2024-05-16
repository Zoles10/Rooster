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
        // Now create the questions table with foreign keyss
        Schema::create('questions', function (Blueprint $table) {
            $table->string('id', 5);
            $table->primary('id');
            $table->string('question', 1023);
            $table->enum('question_type', ['multiple_choice', 'open_ended']);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->boolean('word_cloud')->default(false);
            $table->string('last_note')->nullable();
            $table->date('last_closed')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('questions');
    }
};
