<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProvinciaCollection;
use App\Http\Resources\ProvinciaPoblacionCollection;
use App\Models\Provincia;
use App\Http\Controllers\Controller;
use App\Models\Poblacion;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provincia = Provincia::all();
        return (new ProvinciaCollection($provincia))->response()->setStatusCode(200);
        
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
    public function show(string $id)
    {
        $poblaciones = Poblacion::where('id_provincia', $id)
            ->select('id', 'nombre')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Boda encontrada correctamente',
            'data' =>  new ProvinciaPoblacionCollection($poblaciones)
        ]);
    }

    public function getByProvincia($id, Request $request)
    {
        $query = Poblacion::where('id_provincia', $id);

        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        $poblaciones = $query->select('id', 'nombre')->orderBy('nombre')->get();

        return response()->json(new ProvinciaPoblacionCollection($poblaciones));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provincia $provincia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provincia $provincia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provincia $provincia)
    {
        //
    }
}
