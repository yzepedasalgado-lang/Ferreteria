<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Http\Resources\EmpleadoResource;

class RecursosHumanosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::all();

        return EmpleadoResource::collection($empleados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identidad' => 'required|string|size:13|unique:empleados,identidad',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'salario' => 'required|numeric|min:0',
            'codigo_empleado' => 'required|string|max:13|unique:empleados,codigo_empleado',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado = Empleado::create($request->all());

        return new EmpleadoResource($empleado);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $empleado = Empleado::findOrFail($id);

        return new EmpleadoResource($empleado);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'identidad' => 'sometimes|required|string|size:13|unique:empleados,identidad,' . $id,
            'nombre' => 'sometimes|required|string|max:255',
            'apellido' => 'sometimes|required|string|max:255',
            'cargo' => 'sometimes|required|string|max:255',
            'salario' => 'sometimes|required|numeric|min:0',
            'codigo_empleado' => 'sometimes|required|string|max:13|unique:empleados,codigo_empleado,' . $id,
            'fecha_ingreso' => 'sometimes|required|date',
        ]);

        $empleado->update($request->all());

        return new EmpleadoResource($empleado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);

        $empleado->delete();

        return response()->json([
            'mensaje' => 'Empleado eliminado correctamente'
        ], 200);
    }
}
