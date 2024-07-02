<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = ['placa', 'tipo_vehiculo', 'kilometraje', 'estado', 'nombre_propietario'];

    public function ordenesServicio()
    {
        return $this->hasMany(OrdenServicio::class);
    }
}
