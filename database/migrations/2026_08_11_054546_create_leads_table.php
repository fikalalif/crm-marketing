<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index(); // Di-index agar search cepat
            $table->string('phone');
            $table->string('email')->nullable()->index();
            $table->string('company')->nullable();

            // Status wajib sesuai brief
            $table->enum('status', ['cool', 'warm', 'hot', 'close'])->default('cool')->index();

            $table->string('source')->nullable()->index();
            $table->text('notes')->nullable();

            // Foreign key yang berelasi ke tabel users
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
