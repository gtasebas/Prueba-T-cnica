<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\Order;

class OrderServiceDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_order_service_details()
    {
        $vehicle = Vehicle::create([
            'placa' => 'ABC123',
            'tipo_vehiculo' => 'Automóvil',
            'kilometraje' => 50000,
            'estado' => 'activo',
            'nombre_propietario' => 'Doctor Strange',
        ]);

        $order = Order::create([
            'numero_orden' => 100001,
            'vehiculo_id' => $vehicle->id,
            'tipo_orden' => 'Correctivo',
            'fecha' => '2024-06-01',
        ]);

        $details = [
            [
                'orden_servicio_id' => $order->id,
                'descripcion' => 'Cambio de bujías',
                'cantidad' => 12,
                'valor_unitario' => 25000,
            ],
            [
                'orden_servicio_id' => $order->id,
                'descripcion' => 'Limpieza carter',
                'cantidad' => 1,
                'valor_unitario' => 130000,
            ],
            [
                'orden_servicio_id' => 2,  // Asegúrate de que esta orden exista en tus pruebas
                'descripcion' => 'Lavado de motor',
                'cantidad' => 3,
                'valor_unitario' => 45000,
            ],
        ];

        foreach ($details as $data) {
            $response = $this->postJson('/api/order-service-details', $data);
            $response->assertStatus(201);
            $response->assertJson($data);
            $this->assertDatabaseHas('order_service_details', $data);
        }
    }
}
