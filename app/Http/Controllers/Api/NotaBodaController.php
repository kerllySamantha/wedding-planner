<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotaBodaRequest;
use App\Http\Requests\UpdateNotaBodaRequest;
use App\Models\NotaBoda;

class NotaBodaController extends Controller
{
    public function index()
    {
        return response()->json(NotaBoda::orderBy('created_at', 'desc')->get());
    }

    public function getByBoda(string $bodaId)
    {
        $notas = NotaBoda::where('boda_id', $bodaId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notas);
    }

    public function store(StoreNotaBodaRequest $request)
    {
        $nota = NotaBoda::create($request->validated());

        return response()->json($nota, 201);
    }

    public function show(string $id)
    {
        return response()->json(NotaBoda::findOrFail($id));
    }

    public function update(UpdateNotaBodaRequest $request, string $id)
    {
        $nota = NotaBoda::findOrFail($id);
        $nota->update($request->validated());

        return response()->json($nota);
    }

    public function destroy(string $id)
    {
        NotaBoda::findOrFail($id)->delete();

        return response()->json(['message' => 'Nota eliminada correctamente']);
    }
}
