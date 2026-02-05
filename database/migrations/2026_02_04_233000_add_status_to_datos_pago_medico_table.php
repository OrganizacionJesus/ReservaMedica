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
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('numero_tlf')->comment('Estado activo/inactivo del método de pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_pago_medico', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
