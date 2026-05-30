<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BodaRequest;
use App\Http\Resources\BodaCollection;
use App\Http\Resources\BodaResource;
use App\Models\Boda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BodaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bodas = Boda::with(['usuario', 'poblacion.provincia', 'presupuesto.tipoProducto', 'reservas.empresa'])->paginate(10);
        return new BodaCollection($bodas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BodaRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $data['user_id'] ?? Auth::user()->id;
        $boda = Boda::create($data);
        // $boda->user_id = Auth::id() ?? 1;
        // $boda->nombre_pareja = $request->nombre_pareja;
        // $boda->fecha_boda = $request->fecha_boda;
        // $boda->ubicacion = $request->ubicacion;
        // $boda->user_id = $request->user_id;
        // $boda->presupuesto = $request->presupuesto;
        // $boda->notas = $request->notas;
        // $boda->fotos = $request->validated()['fotos'];
        // $boda->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Boda creada correctamente',
            'data' => $boda
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Boda $boda)
    {
        $boda->load(['usuario', 'poblacion.provincia', 'presupuesto.tipoProducto', 'reservas.empresa', 'usuario.resenias.empresa']);

        if (!$boda) {
            return response()->json([
                'status' => 'error',
                'message' => 'Boda no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Boda encontrada correctamente',
            'data' => new BodaResource($boda)
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $boda = Boda::findOrFail($id);
        $boda->nombre_pareja = $request->nombre_pareja;
        $boda->fecha_boda = $request->fecha_boda;
        $boda->ubicacion = $request->ubicacion;
        $boda->notas = $request->notas;
        if ((int)$request->poblacion_id > 0) {
            $boda->poblacion_id = (int)$request->poblacion_id;
        }
        if ($request->has('fotos')) {
            $boda->fotos = $request->fotos;
        }
        $boda->save();

        return response()->json([
            'succes' => 'Datos modificados correctamente',
            'data' => $boda
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $boda = Boda::findOrFail($id);
        $boda->delete();
    }

    public function getBodaByUserId($usuarioId)
    {
        $boda = Boda::with(['usuario', 'poblacion.provincia', 'presupuesto.tipoProducto', 'reservas.empresa', 'usuario.resenias.empresa'])
            ->where('usuario_id', $usuarioId)
            ->first();

        if (!$boda) {
            return response()->json(['data' => null, 'message' => 'No se encontró boda'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Boda encontrada correctamente',
            'data' => new BodaResource($boda)
        ]);
        ;
    }



}
