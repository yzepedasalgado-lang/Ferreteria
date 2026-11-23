<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $fillable = [
        'identidad',
        'nombre',
        'apellido',
        'cargo',
        'salario',
        'codigo_empleado',
        'fecha_ingreso'
    ];
    public static function reglas($id = null)
    {
        return [
        'identidad' => 'required|digits:13|unique:empleados,identidad,' . $id,
        'nombre' => 'required|max:255',
        'apellido' => 'nullable|required|max:255',
        'cargo' => 'required',
        'salario' => 'required|numeric|min:0',
        'codigo_empleado' => 'nullable|required|digits:13|unique:empleados,codigo_empleado,' . $id,
        'fecha_ingreso' => 'required|date',
        ];
    }
}

