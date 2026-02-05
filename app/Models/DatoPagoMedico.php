<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoPagoMedico extends Model
{
    use HasFactory;

    protected $table = 'datos_pago_medico';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'medico_id',
        'banco',
        'tipo_cuenta',
        'numero_cuenta',
        'titular',
        'cedula',
        'metodo_pago_id',
        'prefijo_tlf',
        'numero_tlf',
        'status'
    ];
    
    protected $casts = [
        'status' => 'boolean'
    ];
    
    /**
     * Relación con el médico
     */
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
    
    /**
     * Relación con el método de pago preferido
     */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'id_metodo');
    }
    
    /**
     * Scope para obtener solo datos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('status', true);
    }
    
    /**
     * Accessor para obtener el número completo de teléfono
     */
    public function getTelefonoCompletoAttribute()
    {
        if ($this->prefijo_tlf && $this->numero_tlf) {
            return $this->prefijo_tlf . '-' . $this->numero_tlf;
        }
        return null;
    }
    
    /**
     * Accessor para obtener la cuenta bancaria formateada
     */
    public function getCuentaFormateadaAttribute()
    {
        if ($this->numero_cuenta) {
            return $this->banco . ' - ' . $this->tipo_cuenta . ': ' . $this->numero_cuenta;
        }
        return null;
    }
}
