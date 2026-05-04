<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SubirImagenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|string',
            'extension' => 'required|in:jpg,jpeg,png,webp,gif',
            'user_id' => 'required|integer'
        ]);

        try {
            $imagenBase64 = $request->input('imagen');
            $extension = $request->input('extension');
            $userId = $request->input('user_id');
            
            $imagen = preg_replace('/^data:image\/\w+;base64,/', '', $imagenBase64);

            $imagenDecodificada = base64_decode($imagen, true);
            if ($imagenDecodificada === false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Imagen en base64 inválida'
                ], 422);
            }

            // Generar carpeta por usuario
            $carpetaUsuario = "imagenes/usuario_{$userId}";

            $extension = strtolower($extension);
            $permitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
            if (!in_array($extension, $permitidas)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Extensión no permitida'
                ], 422);
            }

            // Crear la carpeta si no existe
            if (!Storage::disk('public')->exists($carpetaUsuario)) {
                Storage::disk('public')->makeDirectory($carpetaUsuario);
            }

            // Generar nombre único para la imagen
            $nombreArchivo = uniqid() . '.' . $extension;

            // Guardar dentro de la carpeta del usuario
            Storage::disk('public')->put("{$carpetaUsuario}/{$nombreArchivo}", $imagenDecodificada);

            // Ruta relativa y URL pública
            $path = "{$carpetaUsuario}/{$nombreArchivo}";
            $url = asset("storage/{$path}");

            return response()->json([
                'status' => 'success',
                'path' => $path,
                'url' => $url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar la imagen',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}