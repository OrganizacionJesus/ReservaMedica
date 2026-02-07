<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFacturaRequest extends FormRequest
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
            'cita_id' => [
                'required',
                'exists:citas,id',
                Rule::unique('facturas_pacientes')->where(function ($query) {
                    return $query->where('status', true);
                })
            ],
            'tasa_id' => [
                'required',
                'exists:tasas_dolar,id',
                function ($attribute, $value, $fail) {
                    $tasa = \App\Models\TasaDolar::find($value);
                    if (!$tasa || !$tasa->status) {
                        $fail('La tasa seleccionada no está activa.');
                    }
                }
            ],
            'fecha_emision' => 'required|date|before_or_equal:today',
            'fecha_vencimiento' => 'nullable|date|after:fecha_emision',
            'numero_factura' => 'nullable|unique:facturas_pacientes,numero_factura|max:50'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cita_id.required' => 'Debe seleccionar una cita.',
            'cita_id.exists' => 'La cita seleccionada no existe.',
            'cita_id.unique' => 'Esta cita ya tiene una factura generada.',
            'tasa_id.required' => 'Debe seleccionar una tasa de cambio.',
            'tasa_id.exists' => 'La tasa seleccionada no existe.',
            'fecha_emission.required' => 'La fecha de emisión es requerida.',
            'fecha_emission.before_or_equal' => 'La fecha de emisión no puede ser futura.',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de emisión.',
            'numero_factura.unique' => 'El número de factura ya existe.'
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que la cita esté completada
            if ($this->cita_id) {
                $cita = \App\Models\Cita::find($this->cita_id);
                if ($cita && $cita->estado_cita !== 'Completada') {
                    $validator->errors()->add('cita_id', 'Solo se pueden facturar citas completadas.');
                }
            }

            // Validar que exista configuración de reparto
            if ($this->cita_id) {
                $cita = \App\Models\Cita::find($this->cita_id);
                if ($cita) {
                    $configReparto = \App\Models\ConfiguracionReparto::where('medico_id', $cita->medico_id)
                                                                ->where('consultorio_id', $cita->consultorio_id)
                                                                ->first();
                    
                    if (!$configReparto) {
                        $configReparto = \App\Models\ConfiguracionReparto::where('medico_id', $cita->medico_id)
                                                                    ->whereNull('consultorio_id')
                                                                    ->first();
                    }

                    if (!$configReparto) {
                        $validator->errors()->add('cita_id', 'No existe configuración de reparto para esta cita.');
                    }
                }
            }
        });
    }
}
