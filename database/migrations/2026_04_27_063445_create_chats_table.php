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
        Schema::create('chats', function (Blueprint $table) {

            $table->id();

            // relasi user
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // isi pesan
            $table->text('message');

            // pengirim
            $table->enum('sender', [
                'user',
                'admin'
            ]);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};