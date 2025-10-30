<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = [
        'nombre',
        'capacidad',
        'activa',
    ];

    public function reservaciones()
    {
        return $this->hasMany(Reservaciones::class, 'mesas_id');
    }
}
