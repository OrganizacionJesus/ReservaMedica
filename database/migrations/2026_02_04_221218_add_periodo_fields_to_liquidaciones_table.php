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
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->enum('periodo_tipo', ['quincenal', 'mensual', 'manual'])
                  ->nullable()
                  ->after('entidad_id')
                  ->comment('Tipo de período de liquidación');
            
            $table->date('fecha_inicio_periodo')
                  ->nullable()
                  ->after('periodo_tipo')
                  ->comment('Fecha de inicio del período liquidado');
            
            $table->date('fecha_fin_periodo')
                  ->nullable()
                  ->after('fecha_inicio_periodo')
                  ->comment('Fecha de fin del período liquidado');
            
            // Índices para mejorar performance en consultas
            $table->index(['entidad_tipo', 'entidad_id', 'periodo_tipo'], 'idx_entidad_periodo');
            $table->index(['fecha_inicio_periodo', 'fecha_fin_periodo'], 'idx_fechas_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidaciones', function (Blueprint $table) {
            $table->dropIndex('idx_entidad_periodo');
            $table->dropIndex('idx_fechas_periodo');
            $table->dropColumn(['periodo_tipo', 'fecha_inicio_periodo', 'fecha_fin_periodo']);
        });
    }
};
