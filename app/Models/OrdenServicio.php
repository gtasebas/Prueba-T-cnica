<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    use HasFactory;

    protected $table = 'ordenes_servicio';

    protected $fillable = ['numero_orden','vehiculo_id', 'tipo_orden', 'fecha'];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    public function items()
    {
        /* return $this->hasMany(ItemOrdenServicio::class); */
        return $this->hasMany(ItemOrdenServicio::class, 'orden_servicio_id');
    }
}
