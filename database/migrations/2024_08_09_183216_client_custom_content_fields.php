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
        Schema::create('client_custom_content_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->string('name');
            $table->enum('input_type',['text','textarea','checkbox','number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_custom_content_fields');
    }
};
