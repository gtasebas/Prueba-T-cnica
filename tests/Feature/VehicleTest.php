<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_multiple_vehicles()
    {
        $vehicles = [
            [
                'placa' => 'ABC123',
                'tipo_vehiculo' => 'Automóvil',
                'kilometraje' => 50000,
                'estado' => 'activo',
                'nombre_propietario' => 'Doctor Strange',
            ],
            [
                'placa' => 'DEF456',
                'tipo_vehiculo' => 'Camión',
                'kilometraje' => 15000,
                'estado' => 'activo',
                'nombre_propietario' => 'Viuda negra',
            ],
            [
                'placa' => 'AAA11H',
                'tipo_vehiculo' => 'Moto',
                'kilometraje' => 1500,
                'estado' => 'activo',
                'nombre_propietario' => 'Thor',
            ],
        ];

        foreach ($vehicles as $data) {
            $response = $this->postJson('/api/vehicles', $data);
            $response->assertStatus(201);
            $response->assertJson($data);
            $this->assertDatabaseHas('vehicles', $data);
        }
    }
}
