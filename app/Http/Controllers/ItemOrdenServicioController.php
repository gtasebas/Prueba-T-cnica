<?php

namespace App\Http\Controllers;

use App\Models\ItemOrdenServicio;
use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class ItemOrdenServicioController extends Controller
{
    public function index()
    {
        return ItemOrdenServicio::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'orden_servicio_id' => 'required|exists:ordenes_servicio,id',
            'descripcion' => 'required|string',
            'cantidad' => 'required|integer',
            'valor_unitario' => 'required|numeric',
        ]);

        // Verificar si el ítem ya existe en la orden de servicio
        $itemExistente = ItemOrdenServicio::where('orden_servicio_id', $request->orden_servicio_id)
            ->where('descripcion', $request->descripcion)
            ->first();

        if ($itemExistente) {
            return response()->json(['error' => 'El ítem ya se encuentra en la orden de servicio'], 400);
        }

        $itemOrdenServicio = ItemOrdenServicio::create($request->all());

        return response()->json($itemOrdenServicio, 201);
    }

    public function show(ItemOrdenServicio $itemOrdenServicio)
    {
        return $itemOrdenServicio;
    }

    public function update(Request $request, ItemOrdenServicio $itemOrdenServicio)
    {
        $request->validate([
            'orden_servicio_id' => 'required|exists:ordenes_servicio,id',
            'descripcion' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'valor_unitario' => 'required|numeric',
        ]);

        $itemOrdenServicio->update($request->all());

        return $itemOrdenServicio;
    }

    public function destroy(ItemOrdenServicio $itemOrdenServicio)
    {
        $itemOrdenServicio->delete();

        return response()->noContent();
    }
}
