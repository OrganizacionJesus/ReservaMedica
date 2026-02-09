<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de {{ ucfirst($reportType) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 10px;
        }

        h2 {
            color: #1e40af;
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #1e40af;
            color: white;
            font-weight: bold;
        }

        .header {
            margin-bottom: 30px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .kpi-box {
            background: #f3f4f6;
            padding: 15px;
            margin: 10px 0;
            border-left: 4px solid #1e40af;
        }

        .kpi-box strong {
            color: #1e40af;
            font-size: 16px;
        }

        tr.total-row {
            background-color: #e0e7ff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Reporte de {{ ucfirst($reportType) }}</h1>
        <p><strong>Periodo:</strong> {{ $filters['startDate'] }} al {{ $filters['endDate'] }}</p>
        <p><strong>Generado:</strong> {{ date('d/m/Y H:i') }}</p>
    </div>

    @if($reportType === 'operatividad')
        {{-- KPIs Generales --}}
        @php
            $totalCitas = $data['ausentismoData']->sum('total');
            $totalAusentes = $data['ausentismoData']->sum('ausentes');
            $noShowRate = $totalCitas > 0 ? round(($totalAusentes / $totalCitas) * 100, 2) : 0;
        @endphp

        <div class="kpi-box">
            <strong>Índice de Ausentismo (No-Show Rate):</strong> {{ $noShowRate }}%
            <br>
            <small>{{ $totalAusentes }} citas perdidas de {{ $totalCitas }} programadas</small>
        </div>

        {{-- Productividad por Médico --}}
        <h2>Productividad por Médico</h2>
        <table>
            <thead>
                <tr>
                    <th>Médico</th>
                    <th>Especialidad</th>
                    <th>Citas Totales</th>
                    <th>Atendidas</th>
                    <th>Eficiencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['productividadMedicos'] ?? [] as $medico)
                    <tr>
                        <td>{{ $medico->medico->nombre_completo ?? 'Sin nombre' }}</td>
                        <td>{{ $medico->medico->especialidades->first()->nombre ?? 'Sin especialidad' }}</td>
                        <td style="text-align: center">{{ $medico->total }}</td>
                        <td style="text-align: center">{{ $medico->atendidas }}</td>
                        <td style="text-align: center">{{ round(($medico->atendidas / max(1, $medico->total)) * 100, 1) }}%</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">TOTAL</td>
                    <td style="text-align: center">{{ $data['productividadMedicos']->sum('total') }}</td>
                    <td style="text-align: center">{{ $data['productividadMedicos']->sum('atendidas') }}</td>
                    <td style="text-align: center">
                        {{ $data['productividadMedicos']->sum('total') > 0 ? round(($data['productividadMedicos']->sum('total') / $data['productividadMedicos']->sum('total')) * 100, 1) : 0 }}%
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Ocupación de Consultorios --}}
        <h2>Ocupación por Consultorio</h2>
        <table>
            <thead>
                <tr>
                    <th>Consultorio</th>
                    <th>Citas Programadas</th>
                    <th>Ausencias</th>
                    <th>Tasa de Ausentismo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['ausentismoData'] ?? [] as $item)
                    <tr>
                        <td>{{ $item->consultorio->nombre ?? 'Sin nombre' }}</td>
                        <td style="text-align: center">{{ $item->total }}</td>
                        <td style="text-align: center">{{ $item->ausentes }}</td>
                        <td style="text-align: center">
                            {{ $item->total > 0 ? round(($item->ausentes / $item->total) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="kpi-box">
            <strong>Nota:</strong> El tiempo de espera promedio no está disponible en esta versión del reporte.
            Se calculará en futuras actualizaciones basado en la fecha de solicitud vs. fecha de atención.
        </div>
    @endif

    @if($reportType === 'financiero')
        {{-- Métodos de Pago --}}
        <h2>Ingresos por Método de Pago</h2>
        <table>
            <thead>
                <tr>
                    <th>Método de Pago</th>
                    <th>Total (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['metodosPago'] ?? [] as $metodo)
                    <tr>
                        <td>{{ $metodo->metodo_pago }}</td>
                        <td style="text-align: center">${{ number_format($metodo->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Ingresos por Consultorio --}}
        <h2>Rentabilidad por Consultorio</h2>
        <table>
            <thead>
                <tr>
                    <th>Consultorio</th>
                    <th>Total (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['ingresosConsultorio'] ?? [] as $consultorio)
                    <tr>
                        <td>{{ $consultorio->nombre }}</td>
                        <td style="text-align: center">${{ number_format($consultorio->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Cuentas por Cobrar --}}
        <h2>Cuentas por Cobrar (Facturas Pendientes)</h2>
        @if(count($data['cuentasPorCobrarList'] ?? []) > 0)
            <table>
                <thead>
                    <tr>
                        <th>N° Factura</th>
                        <th>Paciente</th>
                        <th>Fecha Emisión</th>
                        <th>Monto (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['cuentasPorCobrarList'] as $factura)
                        <tr>
                            <td>#{{ $factura->id }}</td>
                            <td>{{ $factura->paciente->nombre_completo ?? 'N/A' }}</td>
                            <td style="text-align: center">{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                            </td>
                            <td style="text-align: center">${{ number_format($factura->monto_usd, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay cuentas por cobrar en este periodo.</p>
        @endif

        {{-- Ticket Promedio --}}
        <div class="kpi-box">
            <strong>Ticket Promedio por Consulta:</strong> ${{ number_format($data['ticketPromedio'] ?? 0, 2) }}
        </div>

        {{-- Total Generado --}}
        <div class="kpi-box" style="margin-top: 10px; background-color: #f0fdf4; border-color: #bbf7d0;">
            <strong>Total Generado (Facturado):</strong> ${{ number_format($data['ingresosTotal'] ?? 0, 2) }}
        </div>
    @endif

    @if($reportType === 'clinico')
        {{-- Top Diagnósticos --}}
        <h2>Principales Diagnósticos (Perfil Epidemiológico)</h2>
        <table>
            <thead>
                <tr>
                    <th>Diagnóstico</th>
                    <th>Total Casos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['topDiagnosticos'] ?? [] as $diag)
                    <tr>
                        <td>{{ $diag->diagnostico }}</td>
                        <td style="text-align: center">{{ $diag->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Demografía Edad --}}
        <h2>Demografía por Rango de Edad</h2>
        <table>
            <thead>
                <tr>
                    <th>Rango de Edad</th>
                    <th>Total Pacientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['demografiaEdad'] ?? [] as $rango => $total)
                    @if($total > 0)
                        <tr>
                            <td>{{ $rango }} años</td>
                            <td style="text-align: center">{{ $total }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{-- Procedencia Geográfica --}}
        <h2>Procedencia Geográfica</h2>
        <table>
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Ciudad</th>
                    <th>Total Pacientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['procedenciaGeografica'] ?? [] as $geo)
                    <tr>
                        <td>{{ $geo->estado }}</td>
                        <td>{{ $geo->ciudad }}</td>
                        <td style="text-align: center">{{ $geo->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Demografía Género --}}
        <h2>Distribución por Género</h2>
        <table>
            <thead>
                <tr>
                    <th>Género</th>
                    <th>Total Pacientes</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPacientes = isset($data['demografiaGenero']) ? $data['demografiaGenero']->sum('total') : 0;
                @endphp
                @foreach($data['demografiaGenero'] ?? [] as $gen)
                    <tr>
                        <td>{{ $gen->genero }}</td>
                        <td style="text-align: center">{{ $gen->total }}</td>
                        <td style="text-align: center">
                            {{ $totalPacientes > 0 ? round(($gen->total / $totalPacientes) * 100, 1) : 0 }}%
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>ReservaMedica - Sistema de Gestión Médica | {{ config('app.name') }}</p>
        <p>Este documento es confidencial y de uso exclusivo autorizado</p>
    </div>
</body>

</html>