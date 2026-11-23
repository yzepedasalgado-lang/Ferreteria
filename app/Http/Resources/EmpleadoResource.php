<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'identidad' => $this->identidad,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'cargo' => $this->cargo,
            'salario' => $this->salario,
            'codigo_empleado' => $this->codigo_empleado,
            'fecha_ingreso' => $this->fecha_ingreso,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
