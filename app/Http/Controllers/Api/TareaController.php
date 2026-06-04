<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::with('boda')->orderBy('created_at', 'desc')->get());
    }

    public function getByBoda(string $bodaId)
    {
        $tareas = Tarea::where('boda_id', $bodaId)
            ->orderByRaw('completada ASC')
            ->orderBy('fecha_limite', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($tareas);
    }

    public function store(StoreTareaRequest $request)
    {
        $tarea = Tarea::create(array_merge(
            $request->validated(),
            ['completada' => false]
        ));

        return response()->json($tarea, 201);
    }

    public function show(Tarea $tarea)
    {
        return response()->json($tarea);
    }

    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $tarea->update($request->validated());

        return response()->json($tarea);
    }

    public function toggleCompletada(Tarea $tarea)
    {
        $tarea->update(['completada' => !$tarea->completada]);

        return response()->json($tarea);
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente']);
    }
}
