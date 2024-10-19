<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('users')->onDelete('cascade'); // Relación con usuarios
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('image')->nullable(); // Columna para la imagen
            $table->dateTime('start_date')->nullable(); // Fecha de inicio
            $table->dateTime('end_date')->nullable();   // Fecha de fin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Elimina toda la tabla, no es necesario eliminar columnas individualmente
        Schema::dropIfExists('job_offers');
    }
}
