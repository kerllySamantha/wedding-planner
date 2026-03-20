<?php

namespace App\Http\Controllers\Api;

use App\Models\Notificacion;
use App\Http\Resources\NotificacionResource;
use App\Http\Controllers\Controller;
use App\Events\NuevaNotificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Notificacion::query()->with('referencia');

        if (request()->filled('user_id')) {
            $query->where('user_id', request('user_id'));
        }

        $notificaciones = $query->orderByDesc('created_at')->paginate(10);

        return NotificacionResource::collection($notificaciones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notificacion $notificacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notificacion $notificacion)
    {
        $validated = $request->validate([
            'leido' => ['required', 'boolean'],
        ]);

        $notificacion->update([
            'leido' => (bool) $validated['leido'],
        ]);


        $notificacion->load('referencia');

        // broadcast(new NuevaNotificacion($notificacion));

        return response()->json([
            'message' => 'Notificacion actualizada correctamente',
            'data' => new NotificacionResource($notificacion),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificacion $notificacion)
    {
        //
    }
}
