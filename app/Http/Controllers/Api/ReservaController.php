<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaRequest;
use App\Http\Resources\ReservaCollection;
use App\Http\Resources\ReservaResource;
use App\Models\Boda;
use App\Models\Producto;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'empresa', 'boda'])->paginate(10);
        return new ReservaCollection($reservas);
        // return response()->json($reservas, 201);
    }

    /**
     * Show the form for creating a new resource.
     */


    public function show(Reserva $reserva)
    {
        $reserva = Reserva::with('producto.tipoProducto.categoria')->first();




        if (!$reserva) {
            return response()->json([
                'message' => 'No existe ninguna resenia con ese id',
                'status' => 'error'
            ], 404);
        }

        return new ReservaResource($reserva);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        $reserva = Reserva::create([
            'user_id' => $request->user_id,
            'empresa_id' => $request->empresa_id,
            'boda_id' => $request->boda_id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado ?? 'pendiente',
            'origen' => $request->origen ?? 'proveedor',
            'notas' => $request->notas,
        ]);

        return response()->json($reserva, 201);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'fecha_inicio' => $request->fecha_inicio ?? $reserva->fecha_inicio,
            'fecha_fin' => $request->fecha_fin ?? $reserva->fecha_fin,
            'estado' => $request->estado ?? $reserva->estado,
            'notas' => $request->notas ?? $reserva->notas,
        ]);

        return response()->json($reserva, 201);
    }

    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = 'cancelada';
        $reserva->save();

        return response()->json(['message' => 'Reserva cancelada']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return response()->json(['message' => 'Datos eliminados correctamente', 200]);
    }


    public function getRersevaPorConfirmar(string $id, string $estado)
    {

        $reservas = Reserva::where('empresa_id', (int) $id)
            ->where('estado', $estado)
            ->get();


        return new ReservaCollection($reservas);
    }

    public function getReservaEmpresa(string $id)
    {

        $reservas = Reserva::where('empresa_id', (int) $id)
            ->get();


        return new ReservaCollection($reservas);
    }

    public function verificarDisponibilidad(Request $request)
    {
        $producto = Producto::find($request->producto_id);
        $fecha = $request->fecha_inicio;

        // 1. Contar cuántas reservas CONFIRMADAS hay para ese producto en esa fecha
        $reservasExistentes = Reserva::where('producto_id', $producto->id)
            ->whereDate('fecha_inicio', $fecha)
            ->where('estado', 'confirmada')
            ->count();

        // 2. Comparar con el "stock_paralelo"
        if ($reservasExistentes >= $producto->stock_paralelo) {
            return response()->json(['disponible' => false, 'msj' => 'Agenda llena para esta fecha'], 400);
        }

        return response()->json(['disponible' => true]);
    }

    public function getCalendario(string $id)
    {

        $reservas = Reserva::with(['boda', 'usuario', 'empresa'])->where('empresa_id', $id)->get();

        $data = $reservas->map(function ($r) {
            return [
                'id' => (string) $r->id,
                'title' => $r->boda->nombre_pareja
                    ?? $r->usuario->name
                    ?? 'Reserva',

                'start' => Carbon::parse($r->fecha_inicio)->toIso8601String(),
                'end' => Carbon::parse($r->fecha_fin)->toIso8601String(),

                'backgroundColor' => Helper::colorPorEstado($r->estado),
                'borderColor' => Helper::colorPorEstado($r->estado),

                'extendedProps' => [
                    'estado' => $r->estado,
                    'origen' => $r->origen,
                    'notas' => $r->notas,

                    'cliente' => $r->usuario ? [
                        'id' => $r->usuario->id,
                        'name' => $r->usuario->name,
                        'rol' => $r->usuario->getRoleNames()->first()
                    ] : null,

                    'empresa' => [
                        'id' => $r->empresa->id,
                        'nombre_empresa' => $r->empresa->nombre_empresa
                    ],

                    'boda' => $r->boda ? [
                        'id' => $r->boda->id,
                        'nombre_pareja' => $r->boda->nombre_pareja,
                        'fecha' => $r->boda->fecha
                    ] : null,

                    // 'servicio' => $r->servicio ? [
                    //     'id' => $r->servicio->id,
                    //     'nombre' => $r->servicio->nombre
                    // ] : null,
                    'tipo_reserva' => $r->tipo_reserva,
                    'all_day' => $r->all_day,

                    'producto' => $r->producto ? [
                        'id' => $r->producto->id,
                        'nombre' => $r->producto->nombre,
                        'categoria' => $r->producto->tipoProducto->categoria->nombre ?? "",
                        'tipo_producto' => $r->producto->tipoProducto->nombre ?? "",
                        // 'modalidad' => $r->producto->tipoProducto->modalidad ?? "",
                    ] : null,
                ]
            ];
        });

        return response()->json($data);
    }
}
