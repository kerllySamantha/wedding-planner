<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PoblacionCollection;
use App\Models\Poblacion;
use App\Http\Controllers\Controller;
use App\Http\Resources\PoblacionResourse;
use Illuminate\Http\Request;

class PoblacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('provincia')) {
            $provinciaId = $request->input('provincia');

            $poblaciones = Poblacion::where('id_provincia', $provinciaId)->get();
        } else {
            $poblaciones = Poblacion::all();
        }

        return (new PoblacionCollection($poblaciones))->response()->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Poblacion $poblacion)
    {
        $poblacion->load('provincia');

        return new PoblacionResourse($poblacion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poblacion $poblacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poblacion $poblacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poblacion $poblacion)
    {
        //
    }
}
