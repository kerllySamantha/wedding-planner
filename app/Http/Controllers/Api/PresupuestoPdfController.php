<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boda;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PresupuestoPdfController extends Controller
{
    public function generarPorBoda(Request $request, $bodaId)
    {
        $boda = Boda::with([
            'presupuesto.tipoProducto.categoria',
            'presupuesto.itemsPresupuesto.tipoProducto',
        ])->find($bodaId);

        if (!$boda) {
            return response()->json(['message' => 'Boda no encontrada'], 404);
        }

        $presupuestos = $boda->presupuesto;

        $totalPresupuestado = $presupuestos->sum('monto_total');
        $totalPagado        = $presupuestos->sum('monto_pagado');
        $totalPendiente     = $totalPresupuestado - $totalPagado;
        $porcentajeEjecutado = $totalPresupuestado > 0
            ? round(($totalPagado / $totalPresupuestado) * 100, 1)
            : 0;

        $categorias = $presupuestos->groupBy(function ($p) {
            return $p->tipoProducto?->categoria?->nombre ?? 'Sin categoría';
        })->map(function ($grupo, $nombreCategoria) {
            $montoTotal  = $grupo->sum('monto_total');
            $montoPagado = $grupo->sum('monto_pagado');
            return [
                'nombre'       => $nombreCategoria,
                'monto_total'  => $montoTotal,
                'monto_pagado' => $montoPagado,
                'pendiente'    => $montoTotal - $montoPagado,
                'tipos'        => $grupo->map(fn($p) => [
                    'tipo'         => $p->tipoProducto?->nombre ?? '—',
                    'monto_total'  => $p->monto_total ?? 0,
                    'monto_pagado' => $p->monto_pagado ?? 0,
                    'pendiente'    => ($p->monto_total ?? 0) - ($p->monto_pagado ?? 0),
                    'estado'       => $p->estado,
                    'items'        => $p->itemsPresupuesto->map(fn($i) => [
                        'nombre'         => $i->nombre_tipo_personalizado ?? ($i->tipoProducto?->nombre ?? '—'),
                        'monto_estimado' => $i->monto_estimado ?? 0,
                        'monto_pagado'   => $i->monto_pagado ?? 0,
                        'notas'          => $i->notas,
                    ])->values()->toArray(),
                ])->values()->toArray(),
            ];
        })->values()->toArray();

        $data = [
            'boda'                => $boda,
            'categorias'          => $categorias,
            'totalPresupuestado'  => $totalPresupuestado,
            'totalPagado'         => $totalPagado,
            'totalPendiente'      => $totalPendiente,
            'porcentajeEjecutado' => $porcentajeEjecutado,
            'fechaGeneracion'     => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.presupuesto', $data)
            ->setPaper('a4', 'portrait');

        $nombreArchivo = 'presupuesto-boda-' . $bodaId . '-' . now()->format('Ymd') . '.pdf';

        return $pdf->download($nombreArchivo);
    }
}
