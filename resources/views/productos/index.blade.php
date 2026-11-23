@extends('layouts.admin')

@section('titulo', 'Lista de Productos')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"> Inventario de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Producto
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Listado General - Ferretería La Bendición</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio (L.)</th>
                        <th>Stock</th>
                        <th class="text-center" style="width: 160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td class="fw-bold">{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion ?? 'Sin descripción' }}</td>
                        <td>L. {{ number_format($producto->precio, 2) }}</td>
                        <td>
                            @if($producto->stock <= 5)
                                <span class="badge bg-danger">{{ $producto->stock }} (Bajo)</span>
                            @else
                                <span class="badge bg-success">{{ $producto->stock }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No hay productos registrados aún.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $productos->links() }}
    </div>
</div>
@endsection