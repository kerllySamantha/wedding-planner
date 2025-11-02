<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservaRequest;
use App\Http\Resources\ReservaCollection;
use App\Models\Boda;
use App\Models\Reserva;
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
    }

    /**
     * Show the form for creating a new resource.
     */


    public function show(string $id)
    {
        $reserva = Reserva::findOrFail($id);

        if (!$reserva) {
            return response()->json([
                'message' => 'No existe ninguna resenia con ese id',
                'status' => 'error'
            ], 404);
        }

        return response()->json($reserva, 201);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request)
    {
        $reserva = new Reserva();
        $validated = $request->validated();
        $reserva->user_id = $validated['user_id'];
        $reserva->empresa_id = $validated['empresa_id'];
        $reserva->fecha = $validated['fecha'];
        $reserva->estado = $validated['estado'];
        $reserva->save();

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
        $reserva->user_id = $request->user_id;
        $reserva->empresa_id = $request->empresa_id;
        $reserva->fecha = $request->fecha;
        $reserva->estado = $request->estado;
        $reserva->save();

        return response()->json($reserva, 201);
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
}