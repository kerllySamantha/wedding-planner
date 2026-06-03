<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BodaRequest;
use App\Http\Resources\BodaCollection;
use App\Http\Resources\BodaResource;
use App\Models\Boda;
use App\Models\Tarea;
use App\Models\TareaPlantilla;
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
        $data['usuario_id'] = Auth::id() ?? $data['user_id'] ?? null;
        unset($data['user_id']);
        $boda = Boda::create($data);

        // Auto-crear tareas desde plantillas (fallback inline si la tabla está vacía)
        $plantillas = TareaPlantilla::orderBy('orden')->get();

        if ($plantillas->isEmpty()) {
            $plantillas = collect([
                ['titulo' => 'Fijar la fecha de la boda',          'descripcion' => 'Elegid la fecha definitiva y anotadla en todos vuestros calendarios.'],
                ['titulo' => 'Establecer el presupuesto total',     'descripcion' => 'Definid un presupuesto global antes de contratar ningún servicio.'],
                ['titulo' => 'Crear la lista de invitados',         'descripcion' => 'Haced una lista inicial de invitados para dimensionar el resto de decisiones.'],
                ['titulo' => 'Reservar el lugar de la celebración', 'descripcion' => 'Visitad y reservad el espacio para la ceremonia y/o el banquete.'],
                ['titulo' => 'Contratar catering o restaurante',    'descripcion' => 'Pedid presupuesto y acordad menú, bebidas y servicio.'],
                ['titulo' => 'Contratar fotógrafo y videógrafo',    'descripcion' => 'Revisad portfolios y reservad con antelación, se agotan rápido.'],
                ['titulo' => 'Elegir el vestido de novia',          'descripcion' => 'Visitad tiendas con tiempo suficiente para pruebas y ajustes.'],
                ['titulo' => 'Elegir traje y complementos del novio','descripcion' => 'Compra o alquiler del traje y zapatos.'],
                ['titulo' => 'Contratar música (DJ o banda)',       'descripcion' => 'Escuchad demos y acordad el repertorio para ceremonia y banquete.'],
                ['titulo' => 'Diseñar y enviar invitaciones',       'descripcion' => 'Enviadlas con al menos 2 meses de antelación.'],
                ['titulo' => 'Elegir el pastel de boda',            'descripcion' => 'Degustación y diseño del pastel nupcial.'],
                ['titulo' => 'Preparar decoración floral',          'descripcion' => 'Ramo de novia, centros de mesa y decoración del espacio.'],
                ['titulo' => 'Elegir anillos de boda',              'descripcion' => 'Buscad y encargad las alianzas con margen para grabaciones.'],
                ['titulo' => 'Confirmar asistencia de invitados',   'descripcion' => 'Recoged confirmaciones y actualizad la lista definitiva.'],
                ['titulo' => 'Organizar transporte y alojamiento',  'descripcion' => 'Coordinar traslados y habitaciones para invitados de fuera.'],
                ['titulo' => 'Planificar la luna de miel',          'descripcion' => 'Reservad destino, vuelos y alojamiento.'],
                ['titulo' => 'Ensayo de la ceremonia',              'descripcion' => 'Realizad un ensayo con el officiant y los testigos.'],
                ['titulo' => 'Preparar detalles para invitados',    'descripcion' => 'Recordatorios, favores y detalles de mesa.'],
            ]);
        }

        foreach ($plantillas as $p) {
            Tarea::create([
                'boda_id'     => $boda->id,
                'titulo'      => is_array($p) ? $p['titulo'] : $p->titulo,
                'descripcion' => is_array($p) ? $p['descripcion'] : $p->descripcion,
                'completada'  => false,
            ]);
        }

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
