<?php

namespace App\Http\Controllers;

use App\Models\DatoPagoMedico;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatoPagoMedicoController extends Controller
{
    /**
     * Display the doctor's payment method information
     */
    public function index()
    {
        $user = auth()->user();
        $medico = $user->medico;
        
        if (!$medico) {
            return redirect()->route('medico.dashboard')->with('error', 'No tienes un perfil de médico asociado');
        }
        
        $datosPago = $medico->datosPago;
        $metodosPago = MetodoPago::where('status', true)->get();
        
        return view('medico.metodos-pago.index', compact('datosPago', 'metodosPago'));
    }

    /**
     * Show the form for creating/editing payment method
     */
    public function edit()
    {
        $user = auth()->user();
        $medico = $user->medico;
        
        if (!$medico) {
            return redirect()->route('medico.dashboard')->with('error', 'No tienes un perfil de médico asociado');
        }
        
        $datosPago = $medico->datosPago;
        $metodosPago = MetodoPago::where('status', true)->get();
        
        return view('medico.metodos-pago.edit', compact('datosPago', 'metodosPago'));
    }

    /**
     * Store or update payment method information
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banco' => 'required|string|max:100',
            'tipo_cuenta' => 'required|in:Ahorro,Corriente',
            'numero_cuenta' => 'required|string|max:50',
            'titular' => 'required|string|max:200',
            'cedula' => 'required|string|max:20',
            'metodo_pago_id' => 'required|exists:metodo_pago,id_metodo',
            'prefijo_tlf' => 'nullable|string|max:10',
            'numero_tlf' => 'nullable|string|max:20',
            'status' => 'boolean'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $user = auth()->user();
            $medico = $user->medico;
            
            if (!$medico) {
                return redirect()->route('medico.dashboard')->with('error', 'No tienes un perfil de médico asociado');
            }
            
            // Verificar si ya existen datos
            $datosPago = $medico->datosPago;
            
            if ($datosPago) {
                // Actualizar
                $datosPago->update($request->all());
                $mensaje = 'Métodos de pago actualizados exitosamente';
            } else {
                // Crear nuevo
                DatoPagoMedico::create(array_merge($request->all(), [
                    'medico_id' => $medico->id,
                    'status' => $request->status ?? true
                ]));
                $mensaje = 'Métodos de pago registrados exitosamente';
            }

            DB::commit();
            return redirect()->route('medico.metodos-pago.index')->with('success', $mensaje);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error guardando datos de pago: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar los datos: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update status only
     */
    public function updateStatus(Request $request)
    {
        $user = auth()->user();
        $medico = $user->medico;
        
        if (!$medico) {
            return response()->json(['success' => false, 'message' => 'No tienes un perfil de médico asociado'], 403);
        }
        
        $datosPago = $medico->datosPago;
        
        if (!$datosPago) {
            return response()->json(['success' => false, 'message' => 'No tienes datos de pago configurados'], 404);
        }
        
        try {
            $datosPago->update(['status' => !$datosPago->status]);
            
            return response()->json([
                'success' => true,
                'message' => $datosPago->status ? 'Método de pago activado' : 'Método de pago desactivado',
                'status' => $datosPago->status
            ]);
        } catch (\Exception $e) {
            Log::error('Error actualizando status de datos de pago: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al actualizar'], 500);
        }
    }
}
