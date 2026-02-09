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
        Schema::create('datos_pago_medico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            
            // Datos para Transferencia Bancaria
            $table->string('banco_nombre')->nullable();
            $table->string('cuenta_tipo')->nullable(); // Ahorro, Corriente
            $table->string('cuenta_numero')->nullable();
            $table->string('titular_cuenta')->nullable();
            $table->string('cedula_titular')->nullable();
            
            // Datos para Pago Móvil
            $table->string('pm_operadora')->nullable(); // Movilnet, Movistar, Digitel
            $table->string('pm_numero')->nullable();
            $table->string('pm_cedula')->nullable();
            
            // Datos para Efectivo
            $table->text('efectivo_observaciones')->nullable();
            
            // Configuración
            $table->json('metodos_habilitados')->nullable(); // ["transferencia", "pago_movil", "efectivo"]
            $table->string('metodo_preferido')->nullable(); // Método preferido por defecto
            $table->boolean('activo')->default(true);
            $table->boolean('verificado')->default(false); // Si los datos fueron verificados
            $table->date('fecha_verificacion')->nullable();
            $table->text('notas_internas')->nullable();
            
            $table->timestamps();
            
            $table->unique(['medico_id']);
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_pago_medico');
    }
};
