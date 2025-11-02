<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::with(['usuario', 'productos'])->orderBy('nombre_empresa')->paginate(10);
        return new EmpresaCollection($empresas);

        // return response()->json([
        //     'success' => 'Empresas mostradas correctamente',
        //     'data' => $empresas
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpresaRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['rol']);



        $empresa = Empresa::create([
            'user_id'        => $user->id,
            'nombre_empresa' => $validated['nombre_empresa'],
            'direccion'      => $validated['direccion'],
            'telefono'       => $validated['telefono'],
            'descripcion'    => $validated['descripcion'] ?? null,
            'logo'           => $validated['logo'] ?? null,
            'fotos'          => $validated['fotos'] ?? null,
            'tipo_servicio' => $validated['tipo_servicio'] ?? null
        ]);

        if (isset($validated['servicios']) && is_array($validated['servicios'])) {
            $empresa->servicios()->sync($validated['servicios']);
        }

        // 4. Retornar recurso
        return new EmpresaResource($empresa);
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $empresa = Empresa::with(
            [
                'productos.tipoProducto.categoria',
                'poblacion.provincia',
                'usuario',
            ]   
        )->find($id);

        return new EmpresaResource($empresa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empresa = Empresa::findOrFail($id);
        $user = User::findOrFail($empresa->user_id);


        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->filled('rol')) {
            $user->syncRoles([$request->rol]);
        }

        $user->save();

        $empresa->nombre_empresa = $request->nombre_empresa ?? $empresa->nombre_empresa;
        $empresa->direccion = $request->direccion ?? $empresa->direccion;
        $empresa->telefono = $request->telefono ?? $empresa->telefono;
        $empresa->descripcion = $request->descripcion ?? $empresa->descripcion;
        $empresa->logo = $request->logo ?? $empresa->logo;
        $empresa->tipo_servicio = $request->tipo_servicio ?? $empresa->tipo_servicio;
        // $empresa->fotos = $request->validated()['fotos'];
        // $empresa->categoria_id = $request->categoria_id ?? $empresa->categoria_id;

        $empresa->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Empresa actualizada correctamente',
            'data' =>  new EmpresaResource($empresa->load(['usuario', 'categoria']))
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empresa = Empresa::findOrFail($id);

        $user = $empresa->user;

        $empresa->delete();

        if ($user) {
            $user->delete();
        }
        return  new EmpresaResource($empresa);
    }
}
