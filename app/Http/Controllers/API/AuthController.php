<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * POST /api/login
     * Autentica al empleado de la ferretería y genera un Bearer Token.
     */
    public function login(Request $request): JsonResponse
    {
        // 1. Validamos formato de credenciales
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required|string',
            'device_name' => 'nullable|string', // Nombre del dispositivo (ej. Samsung Cajero 1)
        ]);

        // 2. Intentamos autenticar contra MySQL
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Credenciales inválidas en Ferretería La Bendición'
            ], 401); // 401 Unauthorized
        }

        // 3. Obtenemos el usuario y generamos el Token Sanctum
        $usuario = Auth::user();
        $dispositivo = $request->device_name ?? 'Dispositivo-Desconocido';
        $token = $usuario->createToken($dispositivo)->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Autenticación exitosa',
            'token'   => $token,
            'usuario' => [
                'id'    => $usuario->id,
                'name'  => $usuario->name,
                'email' => $usuario->email,
                'rol'   => $usuario->rol ?? 'empleado',
            ]
        ], 200);
    }

    /**
     * GET /api/perfil
     * Retorna los datos del usuario autenticado vía Token.
     */
    public function perfil(Request $request): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'usuario' => $request->user()
        ], 200);
    }

    /**
     * POST /api/logout
     * Revoca y destruye el token activo para cerrar sesión de forma segura.
     */
    public function logout(Request $request): JsonResponse
    {
        // Eliminamos el token con el que se realizó esta petición
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Token revocado exitosamente. Sesión cerrada.'
        ], 200);
    }
}