<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
    ];

    public function getFullNameAttribute():string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function reservaciones():HasMany    
    {
        return $this->hasMany(Reservaciones::class, 'cliente_id');
    }
}
