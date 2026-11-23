<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transforma el recurso en un array estructurado y seguro.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'codigo'         => $this->codigo_barra,
            'descripcion'    => $this->nombre,
            // Formateo del precio en Lempiras para la interfaz de usuario
            'precio'         => (float) $this->precio,
            'precio_hnl'     => 'L. ' . number_format($this->precio_venta, 2),
            'disponibilidad' => $this->stock > 0 ? 'En Existencia' : 'Agotado',
            'stock_unidades' => (int) $this->stock,
            'categoria'      => $this->categoria ? $this->categoria->nombre : 'Sin categoría',
            'fecha_registro' => $this->created_at->format('d/m/Y H:i A'),
            // Ocultamos intencionalmente costo_compra y campos sensibles del proveedor
        ];
    }
}