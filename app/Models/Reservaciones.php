<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservaciones extends Model
{
    use HasFactory;

    protected $table = 'reservaciones';

    protected $fillable = [
        'cliente_id',
        'mesas_id',
        'fecha_reserva',
        'comensales',
        'estado',
        'notas',
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesas::class, 'mesas_id');
    }
}
