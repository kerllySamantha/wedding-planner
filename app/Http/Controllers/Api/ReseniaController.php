<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReseniaRequest;
use App\Http\Requests\UpdateReseniaRequest;
use App\Http\Resources\ReseniaCollection;
use App\Http\Resources\ReseniaEmpresaCollection;
use App\Http\Resources\ReseniaResource;
use App\Models\Boda;
use App\Models\Resenia;
use Illuminate\Http\Request;

class ReseniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resenias = Resenia::with(['usuario', 'empresa'])->get();
        return ReseniaResource::collection($resenias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReseniaRequest $request)
    {
        $validated = $request->validated();
        $userId    = $validated['user_id'];
        $empresaId = $validated['empresa_id'];

        // Solo se puede reseñar a un proveedor de la boda, y solo cuando la fecha ha pasado
        $bodaConReserva = Boda::where('usuario_id', $userId)
            ->whereDate('fecha_boda', '<=', today())
            ->whereHas('reservas', fn ($q) => $q->where('empresa_id', $empresaId))
            ->exists();

        if (!$bodaConReserva) {
            return response()->json([
                'message' => 'Solo puedes reseñar a proveedores de tu boda y una vez que haya pasado la fecha del evento.',
                'status'  => 'error',
            ], 403);
        }

        // Evitar reseñas duplicadas
        if (Resenia::where('user_id', $userId)->where('empresa_id', $empresaId)->exists()) {
            return response()->json([
                'message' => 'Ya has escrito una reseña para este proveedor.',
                'status'  => 'error',
            ], 409);
        }

        $resenia = new Resenia();

        $resenia->user_id    = $userId;
        $resenia->empresa_id = $empresaId;
        $resenia->puntuacion = $validated['puntuacion'];
        $resenia->comentario = $validated['comentario'];
        $resenia->fotos      = $validated['fotos'] ?? [];

        if (!$resenia->save()) {
            return response()->json([
                'message' => 'No se ha podido realizar la resenia',
                'status' => 'error'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'data' => $resenia,
            'message' => 'Se ha realizado la resenia correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resenia = Resenia::findOrFail($id);

        if (!$resenia) {
            return response()->json([
                'message' => 'No existe ninguna resenia con ese id',
                'status' => 'error'
            ], 404);
        }

        return response()->json($resenia, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReseniaRequest $request, string $id)
    {
        $resenia   = Resenia::findOrFail($id);
        $validated = $request->validated();

        if (isset($validated['puntuacion'])) $resenia->puntuacion = $validated['puntuacion'];
        if (isset($validated['comentario'])) $resenia->comentario = $validated['comentario'];
        if (array_key_exists('fotos', $validated)) $resenia->fotos = $validated['fotos'] ?? [];
        if (!$resenia->save()) {
            return response()->json([
                'message' => 'No se ha podido actualizar la resenia',
                'status' => 'error'
            ], 401);
        }
        return response()->json([
            'status' => 'success',
            'data' => $resenia,
            'message' => 'Se ha actualizado la resenia correctamente'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resenia = Resenia::findOrFail($id);
        $resenia->delete();

        return response()->json([
            'message' => 'Datos eliminados correctamente',
            'status' => 'success',

        ], 200);
    }

    public function getReseniaEmpresa(string $idEmpresa)
    {
        $resenias = Resenia::with(['usuario', 'empresa'])
            ->where('empresa_id', $idEmpresa)
            ->whereNotNull('comentario')->paginate(10);



        return new ReseniaEmpresaCollection($resenias);

    }


    public function getReseniasValoradas(string $idEmpresa, Request $request)
    {
        $query = Resenia::with(['usuario']) 
            ->where('empresa_id', $idEmpresa)
            ->whereNotNull('comentario');

        // Filtro por tipo
        if ($request->tipo === 'positivas') {
            $query->where('puntuacion', '>=', 4);
        }

        if ($request->tipo === 'negativas') {
            $query->where('puntuacion', '<=', 2);
        }

        $resenias = $query->latest()->paginate(10);

        return new ReseniaCollection($resenias) ;
    }
}