<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function listarOrdenesPorFechaYCliente(Request $request)
    {
        $fecha = $request->input('fecha');
        $cliente = $request->input('cliente');

        // Obtener las órdenes de servicio que coinciden con la fecha y opcionalmente con el cliente
        $ordenes = OrdenServicio::with(['vehiculo', 'items'])
            ->whereDate('fecha', $fecha)
            ->when($cliente, function ($query, $cliente) {
                return $query->whereHas('vehiculo', function ($query) use ($cliente) {
                    $query->where('nombre_propietario', $cliente);
                });
            })
            ->get();

        $resultado = [];

        foreach ($ordenes as $orden) {
            foreach ($orden->items as $item) {
                $resultado[] = [
                    'fecha' => $orden->fecha,
                    'cliente' => $orden->vehiculo->nombre_propietario,
                    'placa' => $orden->vehiculo->placa,
                    'numero_orden' => $orden->numero_orden,
                    'tipo_orden' => $orden->tipo_orden,
                    'item' => $item->descripcion,
                    'cantidad' => $item->cantidad,
                    'valor_unitario' => $item->valor_unitario
                ];
            }
        }

        return response()->json($resultado);
    }
}