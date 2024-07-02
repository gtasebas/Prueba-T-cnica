<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        return Vehiculo::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|unique:vehiculos',
            'tipo_vehiculo' => 'required',
            'kilometraje' => 'required|integer',
            'estado' => 'required',
            'nombre_propietario' => 'required',
        ]);

        return Vehiculo::create($request->all());
    }

    public function show(Vehiculo $vehiculo)
    {
        return $vehiculo;
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $request->validate([
            'placa' => 'required|unique:vehiculos,placa,' . $vehiculo->id,
            'tipo_vehiculo' => 'required',
            'kilometraje' => 'required|integer',
            'estado' => 'required',
            'nombre_propietario' => 'required',
        ]);

        $vehiculo->update($request->all());

        return $vehiculo;
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return response()->noContent();
    }
}
