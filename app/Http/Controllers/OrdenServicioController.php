<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class OrdenServicioController extends Controller
{
    public function index()
    {
        return OrdenServicio::with('vehiculo', 'items')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'tipo_orden' => 'required',
            'fecha' => 'required|date',
            'numero_orden' => 'required|integer|unique:ordenes_servicio,numero_orden',
            'items' => 'sometimes|array',  // Asegurarse de que 'items' sea un array si está presente
        ]);

        $vehiculo = Vehiculo::find($request->vehiculo_id);

        if ($vehiculo->estado == 'inactivo') {
            return response()->json(['error' => 'Vehículo inactivo'], 400);
        }

        // Verificar si algún ítem ya está en la orden de servicio
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $ordenExistente = OrdenServicio::where('vehiculo_id', $request->vehiculo_id)
                    ->whereHas('items', function ($query) use ($item) {
                        $query->where('descripcion', $item['descripcion']);
                    })
                    ->first();

                if ($ordenExistente) {
                    return response()->json(['error' => 'El ítem ya se encuentra en la orden de servicio'], 400);
                }
            }
        }

        // Crear la nueva orden de servicio
        $ordenServicio = OrdenServicio::create($request->only(['vehiculo_id', 'tipo_orden', 'fecha', 'numero_orden']));

        // Añadir los ítems a la orden de servicio
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $ordenServicio->items()->create($item);
            }
        }

        return response()->json($ordenServicio->load('vehiculo', 'items'), 201);
    }

    public function show(OrdenServicio $ordenServicio)
    {
        return $ordenServicio->load('vehiculo', 'items');
    }

    public function update(Request $request, OrdenServicio $ordenServicio)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'tipo_orden' => 'required',
            'fecha' => 'required|date',
        ]);

        $ordenServicio->update($request->all());

        return $ordenServicio;
    }

    public function destroy(OrdenServicio $ordenServicio)
    {
        $ordenServicio->delete();

        return response()->noContent();
    }

    public function reporte(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
        ]);

        $ordenes = OrdenServicio::whereBetween('fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->with('vehiculo', 'items')
            ->get();

        return $ordenes;
    }
}
