<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Auditoria extends Model
{
    protected $fillable = [
        'user_id',
        'accion', 
        'tabla_afectada',
        'registro_id',
        'descripcion',
        'valores_anteriores',
        'valores_nuevos'
    ];

    protected $casts = [
        'valores_anteriores' => 'array',
        'valores_nuevos' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    // Para traer la propiedad afectada
    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'registro_id');
    }
}