<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerarLiquidacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tipo_periodo' => 'required|in:Quincenal,Mensual',
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:today',
            'entidad_tipo' => 'nullable|in:Medico,Consultorio',
            'entidad_id' => 'nullable|integer|min:1',
            'metodo_pago' => 'required_if:accion,procesar|in:Transferencia,Zelle,Efectivo,Pago Movil,Otro',
            'referencia' => 'required_if:accion,procesar|max:100',
            'observaciones' => 'nullable|string|max:500',
            'accion' => 'nullable|in:generar,procesar'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'tipo_periodo.required' => 'Debe seleccionar el tipo de período.',
            'tipo_periodo.in' => 'El tipo de período debe ser Quincenal o Mensual.',
            'fecha_inicio.required' => 'La fecha de inicio es requerida.',
            'fecha_fin.required' => 'La fecha de fin es requerida.',
            'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha de fin.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
            'fecha_fin.before_or_equal' => 'La fecha de fin no puede ser futura.',
            'entidad_tipo.in' => 'La entidad debe ser Médico o Consultorio.',
            'metodo_pago.required_if' => 'El método de pago es requerido al procesar la liquidación.',
            'metodo_pago.in' => 'El método de pago seleccionado no es válido.',
            'referencia.required_if' => 'La referencia es requerida al procesar la liquidación.',
            'referencia.max' => 'La referencia no puede exceder 100 caracteres.',
            'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres.'
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que no exista liquidación duplicada
            if ($this->filled('entidad_tipo') && $this->filled('entidad_id') && 
                $this->filled('fecha_inicio') && $this->filled('fecha_fin')) {
                
                $existe = \App\Models\Liquidacion::where('entidad_tipo', $this->entidad_tipo)
                                                ->where('entidad_id', $this->entidad_id)
                                                ->where('fecha_pago', '>=', $this->fecha_inicio)
                                                ->where('fecha_pago', '<=', $this->fecha_fin)
                                                ->exists();

                if ($existe) {
                    $validator->errors()->add('entidad_id', 'Ya existe una liquidación para esta entidad en el período especificado.');
                }
            }

            // Validar que existan facturas pendientes para el período
            if ($this->filled('fecha_inicio') && $this->filled('fecha_fin')) {
                $facturasPendientes = \App\Models\FacturaTotal::where('estado_liquidacion', 'Pendiente')
                                                              ->where('status', true)
                                                              ->whereHas('cabecera', function ($q) {
                                                                  $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);
                                                              });

                if ($this->filled('entidad_tipo')) {
                    $facturasPendientes->where('entidad_tipo', $this->entidad_tipo);
                }

                if ($this->filled('entidad_id')) {
                    $facturasPendientes->where('entidad_id', $this->entidad_id);
                }

                if ($facturasPendientes->count() === 0) {
                    $validator->errors()->add('fecha_inicio', 'No existen facturas pendientes para liquidar en el período especificado.');
                }
            }

            // Validar que el período sea válido según el tipo
            if ($this->filled('tipo_periodo') && $this->filled('fecha_inicio') && $this->filled('fecha_fin')) {
                $inicio = \Carbon\Carbon::parse($this->fecha_inicio);
                $fin = \Carbon\Carbon::parse($this->fecha_fin);
                $diasPeriodo = $inicio->diffInDays($fin) + 1;

                if ($this->tipo_periodo === 'Quincenal' && ($diasPeriodo < 14 || $diasPeriodo > 16)) {
                    $validator->errors()->add('tipo_periodo', 'El período quincenal debe tener entre 14 y 16 días.');
                }

                if ($this->tipo_periodo === 'Mensual' && ($diasPeriodo < 28 || $diasPeriodo > 31)) {
                    $validator->errors()->add('tipo_periodo', 'El período mensual debe tener entre 28 y 31 días.');
                }
            }
        });
    }
}
