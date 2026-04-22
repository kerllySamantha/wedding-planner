<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\ProductoResource;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['rol']);

        $empresa = $user->empresa()->create(Arr::except($validated, ['name', 'email', 'password', 'rol']));

        // $empresa->servicios()->attach($validated['servicios'] ?? []);

        return new EmpresaResource($empresa->load('user'));
    }


    /**
     * Display the specified resource.
     */

    public function show(Empresa $empresa)
    {
        $empresa->load(
            [
                'productos.tipoProducto.categoria',
                'poblacion.provincia',
                'usuario','resenias'
            ]
        )
        ->loadAvg('resenias', 'puntuacion')
        -> loadCount('resenias')->get();

        return new EmpresaResource($empresa);
       // return  response()->json($empresa, 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Empresa $empresa)
    {
        $user = $empresa->usuario;

        $userData = Arr::only($request->all(), ['name', 'email']);
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
        $user->update($userData);

        if ($request->filled('rol')) {
            $user->syncRoles([$request->rol]);
        }

        $empresaData = Arr::only($request->all(), [
            'nombre_empresa',
            'direccion',
            'telefono',
            'descripcion',
            'logo',
            'tipo_servicio',
            // 'fotos', // descomenta si quieres permitir actualizar fotos
            // 'categoria_id', // descomenta si quieres actualizar categoría
        ]);
        $empresa->update($empresaData);

        // 3. Retornar recurso
        return response()->json([
            'status' => 'success',
            'message' => 'Empresa actualizada correctamente',
            'data' => new EmpresaResource($empresa->load(['user', 'categoria'])),
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        $user = $empresa->usuario;
        $empresa->delete();

        if ($user) {
            $user->delete();
        }
        return new EmpresaResource($empresa);
    }

    public function getEmpresaPorUsuario(User $user)
    {
        $empresa = Empresa::where('user_id', $user->id)->first();
        return new EmpresaResource($empresa);
    }

    public function productos(Empresa $empresa)
{
    $productos = $empresa->productos()
        ->latest()
        ->paginate(10);

    return ProductoResource::collection($productos);
}
}
