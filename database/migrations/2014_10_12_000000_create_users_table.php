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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->tinyInteger('rol')->default(3)->comment('1: Admin, 2: Empresa, 3: Postulante, 4: Supervisor');
            $table->char('dni', 8)->nullable()->unique();
            $table->char('ruc', 11)->nullable();
            $table->char('celular', 9)->nullable();
            $table->string('archivo_cv')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_approved')->default(false); // Campo añadido
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            // Agregar el campo empresa_id
            $table->foreignId('empresa_id')->nullable()->constrained('users')->onDelete('cascade'); // Asegúrate de que la relación esté configurada correctamente

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
