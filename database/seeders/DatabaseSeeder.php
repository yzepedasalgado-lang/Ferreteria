<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Importante para cifrar la contraseña

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear el usuario administrador para pruebas en Postman
        User::updateOrCreate(
            ['email' => 'admin@ferreterialabendicion.hn'], // Busca si ya existe por el correo
            [
                'name' => 'Administrador',
                'password' => Hash::make('password123'), // Contraseña cifrada obligatoria
            ]
        );

        // Opcional: si quieres mantener el usuario de prueba genérico
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}