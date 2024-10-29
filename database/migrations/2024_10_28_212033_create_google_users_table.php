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
        Schema::create('google_users', function (Blueprint $table) {
            $table->id();
            // `constrained()` especifica la referencia a la tabla `users` automáticamente.
            // `onDelete('cascade')` asegura que, si el usuario en `users` se elimina,
            // también se eliminará su información en `google_users`.
            $table->unsignedBigInteger('user_id')->unique(); 
            $table->string('google_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
    
            // Establece la clave foránea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_users');
    }
};
