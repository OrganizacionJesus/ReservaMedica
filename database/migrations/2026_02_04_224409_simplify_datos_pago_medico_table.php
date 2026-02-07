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
        // Paso 1: Eliminar campos innecesarios
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->dropColumn([
                'pm_operadora',
                'pm_numero',
                'pm_cedula',
                'efectivo_observaciones',
                'metodos_habilitados',
                'activo',
                'verificado',
                'fecha_verificacion',
                'notas_internas'
            ]);
        });
        
        // Paso 2: Renombrar campos
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->renameColumn('banco_nombre', 'banco');
            $table->renameColumn('cuenta_tipo', 'tipo_cuenta');
            $table->renameColumn('cuenta_numero', 'numero_cuenta');
            $table->renameColumn('titular_cuenta', 'titular');
            $table->renameColumn('cedula_titular', 'cedula');
        });
        
        // Paso 3: Agregar nuevos campos
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            // Agregar campo para método de pago preferido
            $table->foreignId('metodo_pago_id')
                  ->nullable()
                  ->after('cedula')
                  ->constrained('metodo_pago', 'id_metodo')
                  ->onDelete('set null')
                  ->comment('Método de pago preferido del médico');
            
            // Agregar telefono para contacto
            $table->string('prefijo_tlf', 10)->nullable()->after('metodo_pago_id');
            $table->string('numero_tlf', 20)->nullable()->after('prefijo_tlf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir en orden inverso
        
        // Paso 1: Eliminar nuevos campos
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->dropForeign(['metodo_pago_id']);
            $table->dropColumn(['metodo_pago_id', 'prefijo_tlf', 'numero_tlf']);
        });
        
        // Paso 2: Revertir renombrado de columnas
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->renameColumn('banco', 'banco_nombre');
            $table->renameColumn('tipo_cuenta', 'cuenta_tipo');
            $table->renameColumn('numero_cuenta', 'cuenta_numero');
            $table->renameColumn('titular', 'titular_cuenta');
            $table->renameColumn('cedula', 'cedula_titular');
        });
        
        // Paso 3: Restaurar campos eliminados
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->string('pm_operadora')->nullable();
            $table->string('pm_numero')->nullable();
            $table->string('pm_cedula')->nullable();
            $table->text('efectivo_observaciones')->nullable();
            $table->json('metodos_habilitados')->nullable();
            $table->boolean('activo')->default(true);
            $table->boolean('verificado')->default(false);
            $table->date('fecha_verificacion')->nullable();
            $table->text('notas_internas')->nullable();
        });
    }
};
