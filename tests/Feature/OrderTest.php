<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_service_orders()
    {
        $vehicle1 = Vehicle::create([
            'placa' => 'ABC123',
            'tipo_vehiculo' => 'Automóvil',
            'kilometraje' => 50000,
            'estado' => 'activo',
            'nombre_propietario' => 'Doctor Strange',
        ]);

        $vehicle2 = Vehicle::create([
            'placa' => 'DEF456',
            'tipo_vehiculo' => 'Camión',
            'kilometraje' => 15000,
            'estado' => 'activo',
            'nombre_propietario' => 'Viuda negra',
        ]);

        $vehicle3 = Vehicle::create([
            'placa' => 'AAA11H',
            'tipo_vehiculo' => 'Moto',
            'kilometraje' => 1500,
            'estado' => 'activo',
            'nombre_propietario' => 'Thor',
        ]);

        $orders = [
            [
                'numero_orden' => 100001,
                'vehiculo_id' => $vehicle1->id,
                'tipo_orden' => 'Correctivo',
                'fecha' => '2024-06-01',
            ],
            [
                'numero_orden' => 100002,
                'vehiculo_id' => $vehicle2->id,
                'tipo_orden' => 'Preventivo',
                'fecha' => '2024-06-01',
            ],
            [
                'numero_orden' => 100003,
                'vehiculo_id' => $vehicle1->id,
                'tipo_orden' => 'Correctivo',
                'fecha' => '2024-06-04',
            ],
            [
                'numero_orden' => 100004,
                'vehiculo_id' => $vehicle3->id,
                'tipo_orden' => 'Preventivo',
                'fecha' => '2024-06-12',
            ],
        ];

        foreach ($orders as $data) {
            $response = $this->postJson('/api/orders', $data);
            $response->assertStatus(201);
            $response->assertJson($data);
            $this->assertDatabaseHas('orders', $data);
        }
    }

    /** @test */
    public function it_can_get_orders_report_by_date()
    {
        $vehicle = Vehicle::create([
            'placa' => 'ABC123',
            'tipo_vehiculo' => 'Automóvil',
            'kilometraje' => 50000,
            'estado' => 'activo',
            'nombre_propietario' => 'Doctor Strange',
        ]);

        $orders = [
            [
                'numero_orden' => 100001,
                'vehiculo_id' => $vehicle->id,
                'tipo_orden' => 'Correctivo',
                'fecha' => '2024-06-01',
            ],
            [
                'numero_orden' => 100003,
                'vehiculo_id' => $vehicle->id,
                'tipo_orden' => 'Correctivo',
                'fecha' => '2024-06-04',
            ],
        ];

        foreach ($orders as $data) {
            $this->postJson('/api/orders', $data);
        }

        $response = $this->getJson('/api/reporte-ordenes?fecha=2024-06-01');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }
}
