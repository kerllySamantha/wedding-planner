<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boda;
use App\Models\Tarea;
use App\Models\TareaPlantilla;
use Illuminate\Http\Request;

class TareaPlantillaController extends Controller
{
    public function index()
    {
        return response()->json(TareaPlantilla::orderBy('orden')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:200',
            'descripcion' => 'nullable|string|max:1000',
            'orden'       => 'nullable|integer|min:0',
        ]);

        $data['orden'] ??= TareaPlantilla::max('orden') + 1;
        $plantilla = TareaPlantilla::create($data);

        return response()->json($plantilla, 201);
    }

    public function update(Request $request, TareaPlantilla $tareaPlantilla)
    {
        $data = $request->validate([
            'titulo'      => 'sometimes|required|string|max:200',
            'descripcion' => 'nullable|string|max:1000',
            'orden'       => 'nullable|integer|min:0',
        ]);

        $tareaPlantilla->update($data);

        return response()->json($tareaPlantilla);
    }

    public function destroy(TareaPlantilla $tareaPlantilla)
    {
        $tareaPlantilla->delete();
        return response()->json(null, 204);
    }

    // Aplica todas las plantillas a una boda concreta (sin duplicar las que ya existen)
    public function aplicarABoda(string $bodaId)
    {
        $boda = Boda::findOrFail($bodaId);
        $titulosExistentes = Tarea::where('boda_id', $bodaId)->pluck('titulo')->map(fn($t) => strtolower(trim($t)));
        $plantillas = TareaPlantilla::orderBy('orden')->get();
        $nuevas = [];

        foreach ($plantillas as $p) {
            if ($titulosExistentes->contains(strtolower(trim($p->titulo)))) {
                continue;
            }
            $nuevas[] = Tarea::create([
                'boda_id'     => $boda->id,
                'titulo'      => $p->titulo,
                'descripcion' => $p->descripcion,
                'completada'  => false,
            ]);
        }

        return response()->json(['aplicadas' => count($nuevas), 'tareas' => $nuevas], 201);
    }
}
