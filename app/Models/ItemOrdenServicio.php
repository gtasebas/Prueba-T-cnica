<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemOrdenServicio extends Model
{
    use HasFactory;

    protected $table = 'items_orden_servicio';

    protected $fillable = [
        'orden_servicio_id',
        'descripcion',
        'item',
        'cantidad',
        'valor_unitario',
    ];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }
}
