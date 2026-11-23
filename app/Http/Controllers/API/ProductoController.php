<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductoResource; // Capa de transformación JSON

class ProductoController extends Controller
{
    /**
     * GET /api/productos
     * Devuelve el listado paginado de productos para aplicaciones móviles o frontend.
     */
    public function index(): JsonResponse
    {
        // Paginamos de 10 en 10 para no colapsar la memoria en catálogos gigantes
        $productos = Producto::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => ProductoResource::collection($productos),
            'pagination' => [
                'total'        => $productos->total(),
                'per_page'     => $productos->perPage(),
                'current_page' => $productos->currentPage(),
                'last_page'    => $productos->lastPage(),
            ]
        ], 200); // 200 OK
    }

    /**
     * POST /api/productos
     * Registra un nuevo producto en bodega tras validar los datos.
     */
    public function store(Request $request): JsonResponse
    {
        // 1. Validamos los datos entrantes del payload JSON
        $validados = $request->validate([
            'nombre'       => 'required|string|max:150',
            'precio'       => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
        ]);

        // 2. Insertamos el producto utilizando Eloquent ORM
        $producto = Producto::create($validados);

        // 3. Respondemos con código semántico 201 Created y el recurso transformado
        return response()->json([
            'status'  => 'created',
            'message' => 'Artículo ingresado exitosamente al inventario de Ferretería La Bendición',
            'data'    => new ProductoResource($producto)
        ], 201); // 201 Created
    }

    /**
     * GET /api/productos/{id}
     * Consulta el detalle de un producto específico por su ID primario.
     */
    public function show(string $id): JsonResponse
    {
        // Buscamos el producto en MySQL
        $producto = Producto::find($id);

        // Si no existe, devolvemos error semántico 404
        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => "El producto con ID #{$id} no existe en Ferretería La Bendición"
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'data'   => new ProductoResource($producto)
        ], 200);
    }

    /**
     * PUT /api/productos/{id}
     * Actualiza integralmente los datos del producto en inventario.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Producto no encontrado para actualizar'
            ], 404);
        }

        $validados = $request->validate([
            'nombre'       => 'required|string|max:150',
            'precio'       => 'required|numeric|min:0.01',
            'stock'        => 'required|integer|min:0',
        ]);

        $producto->update($validados);

        return response()->json([
            'status'  => 'updated',
            'message' => 'Producto actualizado correctamente',
            'data'    => new ProductoResource($producto)
        ], 200);
    }

    /**
     * DELETE /api/productos/{id}
     * Da de baja el artículo del sistema.
     */
    public function destroy(string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El producto a eliminar no existe en bodega'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'Producto dado de baja exitosamente'
        ], 200);
    }
}
