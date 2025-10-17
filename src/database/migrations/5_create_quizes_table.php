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
        Schema::create('quizes', function (Blueprint $table) {
            $table->string('id', 5);
            $table->primary('id');
            $table->string('title', 255);
            $table->string('description', 1023)->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->date('last_closed')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('quizes');
    }
};
